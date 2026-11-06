<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class FileUploadService
{
    /**
     * Allowed file extensions for images.
     */
    public const array ALLOWED_EXTENSIONS = ['png', 'jpg', 'jpeg', 'webp', 'gif'];

    /**
     * Allowed MIME types for images.
     */
    public const array ALLOWED_MIME_TYPES = [
        'image/png',
        'image/jpeg',
        'image/webp',
        'image/gif',
    ];

    /**
     * Blocked dangerous extensions (executable, script, or server side scripts).
     */
    public const array BLOCKED_EXTENSIONS = [
        'php', 'phtml', 'php3', 'php4', 'php5', 'php7', 'phps', 'phar',
        'sh', 'bash', 'bat', 'cmd', 'exe', 'com', 'msi', 'bin',
        'pl', 'cgi', 'py', 'rb', 'jar', 'jsp', 'asp', 'aspx',
        'js', 'html', 'htm', 'shtml', 'svg', 'xml',
    ];

    /**
     * Maximum file size in kilobytes (5 MB = 5120 KB).
     */
    public const int MAX_SIZE_KB = 5120;

    /**
     * Get standardized validation rules for secure image uploads.
     *
     * @return list<string>
     */
    public static function imageRules(bool $required = false): array
    {
        return [
            $required ? 'required' : 'nullable',
            'file',
            'mimes:'.implode(',', self::ALLOWED_EXTENSIONS),
            'mimetypes:'.implode(',', self::ALLOWED_MIME_TYPES),
            'max:'.self::MAX_SIZE_KB,
        ];
    }

    /**
     * Validate, sanitize, reprocess and store an uploaded image safely.
     *
     * @throws ValidationException
     */
    public static function storeImage(UploadedFile $file, string $directory, string $fieldKey = 'image'): string
    {
        $originalName = $file->getClientOriginalName();

        // 1. Check for null byte injection
        if (str_contains($originalName, "\0")) {
            throw ValidationException::withMessages([
                $fieldKey => 'ফাইলের নামে অবৈধ ক্যারেক্টার পাওয়া গেছে।',
            ]);
        }

        // 2. Check for blocked extensions in original filename (prevents double extensions e.g. shell.php.jpg)
        $lowerName = strtolower($originalName);
        foreach (self::BLOCKED_EXTENSIONS as $blocked) {
            if (preg_match('/(^|\.)'.preg_quote($blocked, '/').'(\.|$)/i', $lowerName)) {
                throw ValidationException::withMessages([
                    $fieldKey => 'নিরাপত্তার স্বার্থে এই ধরনের ফাইল আপলোড করা সম্পূর্ণ নিষিদ্ধ।',
                ]);
            }
        }

        // 3. Extension Validation
        $clientExtension = strtolower($file->getClientOriginalExtension());
        if (! in_array($clientExtension, self::ALLOWED_EXTENSIONS, true)) {
            throw ValidationException::withMessages([
                $fieldKey => 'অনুমোদিত ফরম্যাট: png, jpg, jpeg, webp, gif।',
            ]);
        }

        // 4. File Size Limits (5 MB)
        if ($file->getSize() > (self::MAX_SIZE_KB * 1024)) {
            throw ValidationException::withMessages([
                $fieldKey => 'ছবির সাইজ সর্বোচ্চ ৫ মেগাবাইট (5 MB) হতে পারবে।',
            ]);
        }

        // 5. Server-side MIME type inspection
        $realPath = $file->getRealPath();
        $detectedMime = $file->getMimeType();
        if (! in_array($detectedMime, self::ALLOWED_MIME_TYPES, true)) {
            throw ValidationException::withMessages([
                $fieldKey => 'ফাইলের ভিতরের MIME টাইপ সঠিক নয়। প্রকৃত ইমেজ ফাইল আপলোড করুন।',
            ]);
        }

        // 6. Image Dimensions & Integrity Validation
        $imageInfo = @getimagesize($realPath);
        if ($imageInfo === false || empty($imageInfo[0]) || empty($imageInfo[1])) {
            throw ValidationException::withMessages([
                $fieldKey => 'ফাইলটি একটি বৈধ ইমেজ নয় বা ছবিটি ক্ষতিগ্রস্ত।',
            ]);
        }

        // 7. Canonical safe extension mapping
        $canonicalExtension = match ($detectedMime) {
            'image/png' => 'png',
            'image/webp' => 'webp',
            'image/gif' => 'gif',
            default => 'jpg',
        };

        // 8. Generate completely random, unpredictable filename
        $randomFileName = Str::random(40).'.'.$canonicalExtension;

        // Ensure target directory exists with proper permissions
        $targetDirectory = public_path('uploads/'.trim($directory, '/'));
        if (! File::exists($targetDirectory)) {
            File::makeDirectory($targetDirectory, 0755, true);
        }

        $destinationPath = $targetDirectory.DIRECTORY_SEPARATOR.$randomFileName;

        // 9. Safe Image Reprocessing with GD (Strips EXIF, metadata, and embedded script payloads)
        $reprocessed = self::reprocessImage($realPath, $destinationPath, $detectedMime);

        if (! $reprocessed) {
            // Fallback: move file securely if GD couldn't re-encode (e.g. animated GIF)
            $file->move($targetDirectory, $randomFileName);
        }

        // Return public relative path
        return 'uploads/'.trim($directory, '/').'/'.$randomFileName;
    }

    /**
     * Reprocess image with GD to strip malicious embedded payloads and recreate clean image pixels.
     */
    protected static function reprocessImage(string $sourcePath, string $destinationPath, string $mime): bool
    {
        try {
            $gdImage = match ($mime) {
                'image/jpeg' => @imagecreatefromjpeg($sourcePath),
                'image/png' => @imagecreatefrompng($sourcePath),
                'image/webp' => @imagecreatefromwebp($sourcePath),
                'image/gif' => @imagecreatefromgif($sourcePath),
                default => null,
            };

            if (! $gdImage) {
                return false;
            }

            // Preserve transparency for PNG and WebP
            if (in_array($mime, ['image/png', 'image/webp'], true)) {
                imagealphablending($gdImage, false);
                imagesavealpha($gdImage, true);
            }

            $success = match ($mime) {
                'image/jpeg' => @imagejpeg($gdImage, $destinationPath, 90),
                'image/png' => @imagepng($gdImage, $destinationPath, 8),
                'image/webp' => @imagewebp($gdImage, $destinationPath, 90),
                'image/gif' => @imagegif($gdImage, $destinationPath),
                default => false,
            };

            imagedestroy($gdImage);

            return (bool) $success;
        } catch (\Throwable) {
            return false;
        }
    }

    /**
     * Safely delete an existing image if it is located inside public/uploads.
     */
    public static function deleteOldImage(?string $relativePath): void
    {
        if (! $relativePath || str_starts_with($relativePath, 'assets/')) {
            return;
        }

        $fullPath = public_path($relativePath);
        $uploadsRoot = realpath(public_path('uploads'));

        // Prevent path traversal: ensure target is strictly inside public/uploads
        $realTarget = realpath($fullPath);
        if ($realTarget && $uploadsRoot && str_starts_with($realTarget, $uploadsRoot)) {
            File::delete($fullPath);
        }
    }
}
