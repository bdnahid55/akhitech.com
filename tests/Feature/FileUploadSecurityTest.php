<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Portfolio;
use App\Models\User;
use App\Services\FileUploadService;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class FileUploadSecurityTest extends TestCase
{
    use RefreshDatabase;

    private User $superAdmin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RolePermissionSeeder::class);

        $this->superAdmin = User::factory()->create();
        $this->superAdmin->assignRole('Super Admin');
    }

    public function test_valid_image_uploads_successfully_with_random_name_and_gd_reprocessing(): void
    {
        // Generate a 100x100 fake valid image
        $file = UploadedFile::fake()->image('test_portfolio_original_name.png', 100, 100);

        $response = $this->actingAs($this->superAdmin)
            ->post(route('admin.portfolios.store'), [
                'title' => 'Project Alpha',
                'category' => 'Web Development',
                'image' => $file,
            ]);

        $response->assertRedirect(route('admin.portfolios.index'));
        $portfolio = Portfolio::where('title', 'Project Alpha')->first();

        $this->assertNotNull($portfolio);
        $this->assertNotNull($portfolio->image);

        // Check random file name instead of original file name
        $this->assertStringNotContainsString('test_portfolio_original_name', $portfolio->image);
        $this->assertMatchesRegularExpression('/uploads\/portfolios\/[A-Za-z0-9]{40}\.png$/', $portfolio->image);

        // Verify the file was stored on disk and can be read as a valid image
        $diskPath = public_path($portfolio->image);
        $this->assertFileExists($diskPath);

        $imageDetails = getimagesize($diskPath);
        $this->assertNotFalse($imageDetails);
        $this->assertSame('image/png', $imageDetails['mime']);

        // Clean up stored file
        FileUploadService::deleteOldImage($portfolio->image);
        $this->assertFileDoesNotExist($diskPath);
    }

    public function test_files_exceeding_5mb_are_rejected(): void
    {
        // 6 MB image file (6 * 1024 KB = 6144 KB)
        $oversizedFile = UploadedFile::fake()->create('huge.jpg', 6144, 'image/jpeg');

        $response = $this->actingAs($this->superAdmin)
            ->post(route('admin.portfolios.store'), [
                'title' => 'Large Project',
                'category' => 'Branding',
                'image' => $oversizedFile,
            ]);

        $response->assertSessionHasErrors('image');
        $this->assertDatabaseMissing('portfolios', ['title' => 'Large Project']);
    }

    public function test_unallowed_extensions_are_rejected(): void
    {
        $pdfFile = UploadedFile::fake()->create('document.pdf', 500, 'application/pdf');

        $response = $this->actingAs($this->superAdmin)
            ->post(route('admin.portfolios.store'), [
                'title' => 'PDF Project',
                'category' => 'Branding',
                'image' => $pdfFile,
            ]);

        $response->assertSessionHasErrors('image');
        $this->assertDatabaseMissing('portfolios', ['title' => 'PDF Project']);
    }

    public function test_spoofed_php_script_disguised_as_image_is_rejected(): void
    {
        // Malicious PHP code disguised as a JPG file
        $maliciousScript = UploadedFile::fake()->createWithContent(
            'shell.jpg',
            "<?php echo 'malicious backdoor code'; ?>"
        );

        $response = $this->actingAs($this->superAdmin)
            ->post(route('admin.portfolios.store'), [
                'title' => 'Exploit Project',
                'category' => 'Security',
                'image' => $maliciousScript,
            ]);

        $response->assertSessionHasErrors('image');
        $this->assertDatabaseMissing('portfolios', ['title' => 'Exploit Project']);
    }

    public function test_double_extension_attack_is_rejected(): void
    {
        // Double extension attack e.g. shell.php.jpg
        $doubleExtFile = UploadedFile::fake()->image('exploit.php.jpg', 50, 50);

        $response = $this->actingAs($this->superAdmin)
            ->post(route('admin.portfolios.store'), [
                'title' => 'Double Ext Project',
                'category' => 'Security',
                'image' => $doubleExtFile,
            ]);

        $response->assertSessionHasErrors('image');
        $this->assertDatabaseMissing('portfolios', ['title' => 'Double Ext Project']);
    }

    public function test_null_byte_injection_is_rejected(): void
    {
        $nullByteFile = UploadedFile::fake()->image("exploit\0.jpg", 50, 50);

        $response = $this->actingAs($this->superAdmin)
            ->post(route('admin.portfolios.store'), [
                'title' => 'Null Byte Project',
                'category' => 'Security',
                'image' => $nullByteFile,
            ]);

        $response->assertSessionHasErrors('image');
        $this->assertDatabaseMissing('portfolios', ['title' => 'Null Byte Project']);
    }

    public function test_uploads_htaccess_blocks_direct_script_execution(): void
    {
        $htaccessPath = public_path('uploads/.htaccess');

        $this->assertFileExists($htaccessPath);
        $content = File::get($htaccessPath);

        // Must match dangerous file extensions
        $this->assertStringContainsString('FilesMatch', $content);
        $this->assertStringContainsString('php', $content);
        $this->assertStringContainsString('phar', $content);
        $this->assertStringContainsString('sh', $content);
        $this->assertStringContainsString('exe', $content);

        // Must deny execution
        $this->assertStringContainsString('Require all denied', $content);
        $this->assertStringContainsString('Options -ExecCGI', $content);
    }
}
