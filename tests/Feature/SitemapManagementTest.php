<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Page;
use App\Models\Post;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class SitemapManagementTest extends TestCase
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

    protected function tearDown(): void
    {
        if (File::exists(public_path('sitemap.xml'))) {
            File::delete(public_path('sitemap.xml'));
        }

        parent::tearDown();
    }

    public function test_public_sitemap_xml_returns_valid_dynamic_xml(): void
    {
        // Create sample content
        Page::create([
            'title' => 'Custom Services SEO Page',
            'slug' => 'custom-services-seo-page',
            'content' => 'Sample content',
            'is_active' => true,
        ]);

        $response = $this->get('/sitemap.xml');

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'text/xml; charset=UTF-8');
        $response->assertSee('<urlset', false);
        $response->assertSee('custom-services-seo-page', false);
    }

    public function test_unauthenticated_user_cannot_access_admin_sitemap_routes(): void
    {
        $this->get(route('admin.sitemap.index'))
            ->assertRedirect(route('admin.login'));

        $this->post(route('admin.sitemap.generate'))
            ->assertRedirect(route('admin.login'));

        $this->get(route('admin.sitemap.download'))
            ->assertRedirect(route('admin.login'));
    }

    public function test_admin_can_view_sitemap_management_interface(): void
    {
        $response = $this->actingAs($this->superAdmin)
            ->get(route('admin.sitemap.index'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.sitemap.index');
        $response->assertViewHas('status');
        $response->assertViewHas('entries');
        $response->assertSee('এসইও সাইটম্যাপ (XML Sitemap)');
    }

    public function test_admin_can_generate_and_update_sitemap_file(): void
    {
        Post::create([
            'title' => 'New SEO Blog Post',
            'slug' => 'new-seo-blog-post',
            'content' => 'Blog content here',
            'is_published' => true,
        ]);

        $response = $this->actingAs($this->superAdmin)
            ->post(route('admin.sitemap.generate'));

        $response->assertRedirect(route('admin.sitemap.index'));
        $response->assertSessionHas('success');

        $this->assertFileExists(public_path('sitemap.xml'));
        $content = File::get(public_path('sitemap.xml'));
        $this->assertStringContainsString('new-seo-blog-post', $content);
    }

    public function test_admin_can_download_sitemap_file(): void
    {
        $response = $this->actingAs($this->superAdmin)
            ->get(route('admin.sitemap.download'));

        $response->assertStatus(200);
        $response->assertHeader('Content-Disposition', 'attachment; filename=sitemap.xml');
    }

    public function test_artisan_command_generates_sitemap_file(): void
    {
        $this->artisan('sitemap:generate')
            ->expectsOutputToContain('Sitemap successfully generated')
            ->assertSuccessful();

        $this->assertFileExists(public_path('sitemap.xml'));
    }
}
