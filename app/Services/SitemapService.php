<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Page;
use App\Models\Portfolio;
use App\Models\Post;
use App\Models\Setting;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;

class SitemapService
{
    /**
     * Get all static URLs included in the sitemap.
     *
     * @return list<array{name: string, url: string, priority: string, changefreq: string, lastmod: string, type: string}>
     */
    public static function getStaticUrls(): array
    {
        $today = Carbon::today()->format('Y-m-d');

        return [
            [
                'name' => 'হোম পেজ (Home)',
                'url' => route('home'),
                'priority' => '1.0',
                'changefreq' => 'daily',
                'lastmod' => $today,
                'type' => 'static',
            ],
            [
                'name' => 'আমাদের সম্পর্কে (About Us)',
                'url' => route('about'),
                'priority' => '0.8',
                'changefreq' => 'monthly',
                'lastmod' => $today,
                'type' => 'static',
            ],
            [
                'name' => 'সার্ভিস সমূহ (Services)',
                'url' => route('services'),
                'priority' => '0.8',
                'changefreq' => 'weekly',
                'lastmod' => $today,
                'type' => 'static',
            ],
            [
                'name' => 'প্যাকেজ ও প্রাইসিং (Packages)',
                'url' => route('packages'),
                'priority' => '0.8',
                'changefreq' => 'weekly',
                'lastmod' => $today,
                'type' => 'static',
            ],
            [
                'name' => 'পোর্টফোলিও (Portfolio)',
                'url' => route('portfolio'),
                'priority' => '0.8',
                'changefreq' => 'weekly',
                'lastmod' => $today,
                'type' => 'static',
            ],
            [
                'name' => 'ব্লগ ও আর্টিকেল (Blog)',
                'url' => route('blog'),
                'priority' => '0.8',
                'changefreq' => 'daily',
                'lastmod' => $today,
                'type' => 'static',
            ],
            [
                'name' => 'যোগাযোগ (Contact Us)',
                'url' => route('contact'),
                'priority' => '0.8',
                'changefreq' => 'monthly',
                'lastmod' => $today,
                'type' => 'static',
            ],
            [
                'name' => 'কোটেশন অনুরোধ (Get Quote)',
                'url' => route('quote'),
                'priority' => '0.8',
                'changefreq' => 'monthly',
                'lastmod' => $today,
                'type' => 'static',
            ],
            [
                'name' => 'প্রাইভেসি পলিসি (Privacy Policy)',
                'url' => route('privacy'),
                'priority' => '0.5',
                'changefreq' => 'yearly',
                'lastmod' => $today,
                'type' => 'static',
            ],
            [
                'name' => 'শর্তাবলী (Terms & Conditions)',
                'url' => route('terms'),
                'priority' => '0.5',
                'changefreq' => 'yearly',
                'lastmod' => $today,
                'type' => 'static',
            ],
        ];
    }

    /**
     * Get all structured entries for the sitemap (Static, Pages, Portfolios, Posts).
     *
     * @return list<array{name: string, url: string, priority: string, changefreq: string, lastmod: string, type: string}>
     */
    public static function getAllEntries(): array
    {
        $entries = self::getStaticUrls();

        // 1. Dynamic Active Pages
        $pages = Page::where('is_active', true)->orderBy('updated_at', 'desc')->get();
        foreach ($pages as $page) {
            $entries[] = [
                'name' => $page->title,
                'url' => route('page.show', $page->slug),
                'priority' => '0.7',
                'changefreq' => 'weekly',
                'lastmod' => $page->updated_at ? $page->updated_at->format('Y-m-d') : date('Y-m-d'),
                'type' => 'page',
            ];
        }

        // 2. Dynamic Active Portfolios
        $portfolios = Portfolio::where('is_active', true)->orderBy('updated_at', 'desc')->get();
        foreach ($portfolios as $portfolio) {
            $entries[] = [
                'name' => $portfolio->title,
                'url' => route('portfolio.show', $portfolio->slug),
                'priority' => '0.7',
                'changefreq' => 'weekly',
                'lastmod' => $portfolio->updated_at ? $portfolio->updated_at->format('Y-m-d') : date('Y-m-d'),
                'type' => 'portfolio',
            ];
        }

        // 3. Dynamic Published Blog Posts
        $posts = Post::where('is_published', true)->orderBy('updated_at', 'desc')->get();
        foreach ($posts as $post) {
            $entries[] = [
                'name' => $post->title,
                'url' => route('blog.show', $post->slug),
                'priority' => '0.7',
                'changefreq' => 'weekly',
                'lastmod' => $post->updated_at ? $post->updated_at->format('Y-m-d') : date('Y-m-d'),
                'type' => 'post',
            ];
        }

        return $entries;
    }

    /**
     * Render the valid XML sitemap string.
     */
    public static function renderXml(): string
    {
        $entries = self::getAllEntries();

        $xml = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n";

        foreach ($entries as $entry) {
            $loc = htmlspecialchars($entry['url'], ENT_XML1, 'UTF-8');
            $xml .= "    <url>\n";
            $xml .= "        <loc>{$loc}</loc>\n";
            $xml .= "        <lastmod>{$entry['lastmod']}</lastmod>\n";
            $xml .= "        <changefreq>{$entry['changefreq']}</changefreq>\n";
            $xml .= "        <priority>{$entry['priority']}</priority>\n";
            $xml .= "    </url>\n";
        }

        $xml .= '</urlset>';

        return $xml;
    }

    /**
     * Generate and write sitemap.xml to public/sitemap.xml and store metadata.
     *
     * @return array{total_urls: int, file_size: string, last_generated_at: string, file_path: string}
     */
    public static function generateFile(): array
    {
        $xmlContent = self::renderXml();
        $filePath = public_path('sitemap.xml');

        File::put($filePath, $xmlContent);

        $now = now();
        $entriesCount = count(self::getAllEntries());
        $fileBytes = File::size($filePath);
        $fileSizeFormatted = self::formatBytes($fileBytes);

        Setting::set('sitemap_last_generated_at', $now->toDateTimeString(), 'seo');
        Setting::set('sitemap_total_urls', (string) $entriesCount, 'seo');

        return [
            'total_urls' => $entriesCount,
            'file_size' => $fileSizeFormatted,
            'last_generated_at' => $now->toDateTimeString(),
            'file_path' => $filePath,
        ];
    }

    /**
     * Get sitemap status information.
     *
     * @return array{
     *     exists: bool,
     *     url: string,
     *     file_path: string,
     *     file_size: string,
     *     last_generated_at: ?string,
     *     total_urls: int,
     *     breakdown: array{static: int, pages: int, portfolios: int, posts: int}
     * }
     */
    public static function getStatus(): array
    {
        $filePath = public_path('sitemap.xml');
        $exists = File::exists($filePath);

        $staticCount = count(self::getStaticUrls());
        $pagesCount = Page::where('is_active', true)->count();
        $portfoliosCount = Portfolio::where('is_active', true)->count();
        $postsCount = Post::where('is_published', true)->count();
        $totalUrls = $staticCount + $pagesCount + $portfoliosCount + $postsCount;

        $fileSize = $exists ? self::formatBytes(File::size($filePath)) : '0 KB';
        $lastGeneratedAt = Setting::get('sitemap_last_generated_at');

        if (! $lastGeneratedAt && $exists) {
            $lastGeneratedAt = Carbon::createFromTimestamp(File::lastModified($filePath))->toDateTimeString();
        }

        return [
            'exists' => $exists,
            'url' => url('/sitemap.xml'),
            'file_path' => $filePath,
            'file_size' => $fileSize,
            'last_generated_at' => $lastGeneratedAt,
            'total_urls' => $totalUrls,
            'breakdown' => [
                'static' => $staticCount,
                'pages' => $pagesCount,
                'portfolios' => $portfoliosCount,
                'posts' => $postsCount,
            ],
        ];
    }

    /**
     * Format bytes to human readable format.
     */
    public static function formatBytes(int $bytes, int $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= 1024 ** $pow;

        return round($bytes, $precision).' '.$units[$pow];
    }
}
