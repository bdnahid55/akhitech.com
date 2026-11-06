<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Achievement;
use App\Models\Inquiry;
use App\Models\Package;
use App\Models\Page;
use App\Models\Portfolio;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Subscriber;
use App\Models\TeamMember;
use App\Models\Testimonial;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RolePermissionSeeder::class);
    }

    /**
     * Create a Super Admin user for testing.
     */
    protected function createSuperAdmin(array $attributes = []): User
    {
        $user = User::factory()->create($attributes);
        $user->assignRole('Super Admin');

        return $user;
    }

    /**
     * Unauthenticated users cannot access admin dashboard.
     */
    public function test_unauthenticated_user_cannot_access_admin_dashboard(): void
    {
        $response = $this->get('/admin');
        $response->assertRedirect('/admin/login');
    }

    /**
     * Admin can view the login page.
     */
    public function test_admin_login_page_is_accessible(): void
    {
        $response = $this->get('/admin/login');
        $response->assertStatus(200);
    }

    /**
     * Admin can authenticate with valid credentials.
     */
    public function test_admin_can_log_in_and_redirect_to_dashboard(): void
    {
        $user = $this->createSuperAdmin([
            'email' => 'admin@akhitech.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post('/admin/login', [
            'email' => 'admin@akhitech.com',
            'password' => 'password123',
        ]);

        $this->assertAuthenticatedAs($user);
        $response->assertRedirect('/admin');
    }

    /**
     * Admin can view dashboard once logged in.
     */
    public function test_authenticated_admin_can_view_dashboard(): void
    {
        $user = $this->createSuperAdmin();

        $response = $this->actingAs($user)->get('/admin');
        $response->assertStatus(200);
        $response->assertSee('ড্যাশবোর্ড');
    }

    /**
     * Admin can create, edit, and delete a service.
     */
    public function test_admin_can_manage_services(): void
    {
        $user = $this->createSuperAdmin();

        // 1. Create Service
        $response = $this->actingAs($user)->post('/admin/services', [
            'title' => 'কাস্টম এআই সল্যুশন',
            'icon' => 'fas fa-robot',
            'short_description' => 'কৃত্রিম বুদ্ধিমত্তা চালিত সফটওয়্যার ডেভেলপমেন্ট।',
            'starting_price' => 15000,
            'is_active' => 1,
        ]);

        $response->assertRedirect('/admin/services');
        $this->assertDatabaseHas('services', ['title' => 'কাস্টম এআই সল্যুশন']);

        $service = Service::where('title', 'কাস্টম এআই সল্যুশন')->first();

        // 2. Edit Service
        $updateResponse = $this->actingAs($user)->put("/admin/services/{$service->id}", [
            'title' => 'কাস্টম এআই ও মেশিন লার্নিং',
            'short_description' => 'আপডেটেড সংক্ষিপ্ত বিবরণ।',
            'starting_price' => 20000,
            'is_active' => 1,
        ]);

        $updateResponse->assertRedirect('/admin/services');
        $this->assertDatabaseHas('services', ['title' => 'কাস্টম এআই ও মেশিন লার্নিং']);

        // 3. Delete Service
        $deleteResponse = $this->actingAs($user)->delete("/admin/services/{$service->id}");
        $deleteResponse->assertRedirect('/admin/services');
        $this->assertDatabaseMissing('services', ['id' => $service->id]);
    }

    /**
     * Admin can create, edit, and delete portfolio projects with dates.
     */
    public function test_admin_can_manage_portfolios_with_dates(): void
    {
        $user = $this->createSuperAdmin();

        // 1. Create Portfolio
        $response = $this->actingAs($user)->post('/admin/portfolios', [
            'title' => 'নতুন ই-কমার্স অ্যাপ',
            'category' => 'মোবাইল অ্যাপ',
            'client_name' => 'বিডি শপ',
            'start_date' => '01/01/2025',
            'end_date' => '02/15/2025',
            'project_url' => 'https://bdshop.example',
            'description' => 'একটি পূর্ণাঙ্গ ফ্ল্যাটার অ্যাপ।',
            'is_active' => 1,
        ]);

        $response->assertRedirect('/admin/portfolios');
        $this->assertDatabaseHas('portfolios', [
            'title' => 'নতুন ই-কমার্স অ্যাপ',
            'start_date' => '01/01/2025',
            'end_date' => '02/15/2025',
        ]);

        $portfolio = Portfolio::where('title', 'নতুন ই-কমার্স অ্যাপ')->first();

        // 2. Edit Portfolio
        $updateResponse = $this->actingAs($user)->put("/admin/portfolios/{$portfolio->id}", [
            'title' => 'আপডেটেড ই-কমার্স অ্যাপ',
            'category' => 'মোবাইল ও ওয়েব অ্যাপ',
            'client_name' => 'বিডি শপ লিমিটেড',
            'start_date' => '01/05/2025',
            'end_date' => '03/01/2025',
            'project_url' => 'https://bdshop.example',
            'description' => 'আপডেটেড বিবরণ।',
            'is_active' => 1,
        ]);

        $updateResponse->assertRedirect('/admin/portfolios');
        $this->assertDatabaseHas('portfolios', [
            'title' => 'আপডেটেড ই-কমার্স অ্যাপ',
            'start_date' => '01/05/2025',
            'end_date' => '03/01/2025',
        ]);

        // 3. Delete Portfolio
        $deleteResponse = $this->actingAs($user)->delete("/admin/portfolios/{$portfolio->id}");
        $deleteResponse->assertRedirect('/admin/portfolios');
        $this->assertDatabaseMissing('portfolios', ['id' => $portfolio->id]);
    }

    /**
     * Admin can view and delete inquiries.
     */
    public function test_admin_can_view_and_delete_inquiry(): void
    {
        $user = $this->createSuperAdmin();
        $inquiry = Inquiry::factory()->create(['is_read' => false]);

        // View inquiry (marks as read)
        $response = $this->actingAs($user)->get("/admin/inquiries/{$inquiry->id}");
        $response->assertStatus(200);
        $this->assertTrue($inquiry->fresh()->is_read);

        // Delete inquiry
        $deleteResponse = $this->actingAs($user)->delete("/admin/inquiries/{$inquiry->id}");
        $deleteResponse->assertRedirect('/admin/inquiries');
        $this->assertDatabaseMissing('inquiries', ['id' => $inquiry->id]);
    }

    /**
     * Admin can delete subscriber.
     */
    public function test_admin_can_delete_subscriber(): void
    {
        $user = $this->createSuperAdmin();
        $subscriber = Subscriber::factory()->create();

        $response = $this->actingAs($user)->delete("/admin/subscribers/{$subscriber->id}");
        $response->assertRedirect('/admin/subscribers');
        $this->assertDatabaseMissing('subscribers', ['id' => $subscriber->id]);
    }

    /**
     * Admin can create, edit, and delete custom pages.
     */
    public function test_admin_can_manage_custom_pages(): void
    {
        $user = $this->createSuperAdmin();

        // 1. Create Page
        $response = $this->actingAs($user)->post('/admin/pages', [
            'title' => 'মিশন ও ভিশন',
            'slug' => 'mission-vision',
            'content' => '<p>আমাদের মূল লক্ষ্য গ্রাহকের সন্তুষ্টি।</p>',
            'show_in_header' => 1,
            'show_in_footer' => 1,
            'footer_column' => 'quick_links',
            'order' => 1,
            'meta_title' => 'মিশন ও ভিশন | আখিটেক',
            'meta_description' => 'আমাদের কোম্পানির মূল দর্শন।',
            'is_active' => 1,
        ]);

        $response->assertRedirect('/admin/pages');
        $this->assertDatabaseHas('pages', ['slug' => 'mission-vision']);

        $page = Page::where('slug', 'mission-vision')->first();

        // 2. Edit Page
        $updateResponse = $this->actingAs($user)->put("/admin/pages/{$page->id}", [
            'title' => 'আমাদের মিশন ও রূপকল্প',
            'slug' => 'mission-vision',
            'content' => '<p>আপডেটেড কনটেন্ট</p>',
            'show_in_header' => 1,
            'show_in_footer' => 0,
            'footer_column' => 'quick_links',
            'order' => 2,
            'meta_title' => 'আপডেটেড মেটা টাইটেল',
            'is_active' => 1,
        ]);

        $updateResponse->assertRedirect('/admin/pages');
        $this->assertDatabaseHas('pages', ['title' => 'আমাদের মিশন ও রূপকল্প', 'order' => 2]);

        // 3. Delete Page
        $deleteResponse = $this->actingAs($user)->delete("/admin/pages/{$page->id}");
        $deleteResponse->assertRedirect('/admin/pages');
        $this->assertDatabaseMissing('pages', ['id' => $page->id]);
    }

    /**
     * Admin can view and update website settings.
     */
    public function test_admin_can_update_website_settings(): void
    {
        $user = $this->createSuperAdmin();

        // View settings page
        $viewResponse = $this->actingAs($user)->get('/admin/settings');
        $viewResponse->assertStatus(200);

        // Update settings
        $updateResponse = $this->actingAs($user)->put('/admin/settings', [
            'site_name' => 'Akhitech Solutions Ltd.',
            'banner_title' => 'স্মার্ট বিজনেস সল্যুশন ও উদ্ভাবন',
            'about_title' => '১০ বছরের সমৃদ্ধ পেশাদার অভিজ্ঞতা',
            'contact_phone' => '+8801999999999',
            'contact_email' => 'hello@akhitech.com',
            'footer_copyright' => '© 2026 Akhitech Solutions Ltd. All rights reserved.',
            'testimonial_subtitle' => 'গ্রাহকদের মতামত',
            'testimonial_title' => 'আমাদের ক্লায়েন্টরা যা বলছেন',
            'team_subtitle' => 'আমাদের স্পেশালিস্ট টিম',
            'team_title' => 'দক্ষ ও অভিজ্ঞ টিম মেম্বারবৃন্দ',
            'achievement_subtitle' => 'আমাদের সাফল্যসমূহ',
            'achievement_title' => 'আমাদের গৌরবোজ্জ্বল অর্জন সমূহ',
            'default_meta_title' => 'Akhitech Solutions | শীর্ষ আইটি সেবা',
            'default_meta_description' => 'বিশ্বমানের সফটওয়্যার সমাধান।',
        ]);

        $updateResponse->assertRedirect('/admin/settings');
        $this->assertEquals('Akhitech Solutions Ltd.', Setting::get('site_name'));
        $this->assertEquals('স্মার্ট বিজনেস সল্যুশন ও উদ্ভাবন', Setting::get('banner_title'));
        $this->assertEquals('১০ বছরের সমৃদ্ধ পেশাদার অভিজ্ঞতা', Setting::get('about_title'));
        $this->assertEquals('গ্রাহকদের মতামত', Setting::get('testimonial_subtitle'));
        $this->assertEquals('আমাদের ক্লায়েন্টরা যা বলছেন', Setting::get('testimonial_title'));
        $this->assertEquals('আমাদের স্পেশালিস্ট টিম', Setting::get('team_subtitle'));
        $this->assertEquals('দক্ষ ও অভিজ্ঞ টিম মেম্বারবৃন্দ', Setting::get('team_title'));
        $this->assertEquals('আমাদের সাফল্যসমূহ', Setting::get('achievement_subtitle'));
        $this->assertEquals('আমাদের গৌরবোজ্জ্বল অর্জন সমূহ', Setting::get('achievement_title'));
        $this->assertEquals('+8801999999999', Setting::get('contact_phone'));
        $this->assertEquals('hello@akhitech.com', Setting::get('contact_email'));
    }

    /**
     * Admin can view, create, edit, and delete testimonials.
     */
    public function test_admin_can_manage_testimonials(): void
    {
        $user = $this->createSuperAdmin();

        // 1. View testimonials index
        $indexResponse = $this->actingAs($user)->get('/admin/testimonials');
        $indexResponse->assertStatus(200);

        // 2. View create form
        $createResponse = $this->actingAs($user)->get('/admin/testimonials/create');
        $createResponse->assertStatus(200);

        // 3. Store new testimonial
        $storeResponse = $this->actingAs($user)->post('/admin/testimonials', [
            'name' => 'তানভীর রহমান',
            'designation' => 'ব্যবস্থাপনা পরিচালক',
            'comment' => 'তাদের সেবা ও কর্মদক্ষতা সত্যিই প্রশংসনীয়। আমাদের কোম্পানির গ্রোথে তারা দারুণ ভূমিকা রেখেছে।',
            'rating' => 5,
            'order' => 1,
            'is_active' => 1,
        ]);

        $storeResponse->assertRedirect('/admin/testimonials');
        $this->assertDatabaseHas('testimonials', [
            'name' => 'তানভীর রহমান',
            'designation' => 'ব্যবস্থাপনা পরিচালক',
            'rating' => 5,
        ]);

        $testimonial = Testimonial::where('name', 'তানভীর রহমান')->firstOrFail();

        // 4. View edit form
        $editResponse = $this->actingAs($user)->get("/admin/testimonials/{$testimonial->id}/edit");
        $editResponse->assertStatus(200);
        $editResponse->assertSee('তানভীর রহমান');

        // 5. Update testimonial
        $updateResponse = $this->actingAs($user)->put("/admin/testimonials/{$testimonial->id}", [
            'name' => 'তানভীর আহমেদ',
            'designation' => 'প্রধান নির্বাহী কর্মকর্তা',
            'comment' => 'আপডেটেড কমেন্ট: সেরা সফটওয়্যার ডেভেলপমেন্ট টিম!',
            'rating' => 5,
            'order' => 2,
            'is_active' => 1,
        ]);

        $updateResponse->assertRedirect('/admin/testimonials');
        $this->assertDatabaseHas('testimonials', [
            'id' => $testimonial->id,
            'name' => 'তানভীর আহমেদ',
            'designation' => 'প্রধান নির্বাহী কর্মকর্তা',
        ]);

        // 6. Delete testimonial
        $deleteResponse = $this->actingAs($user)->delete("/admin/testimonials/{$testimonial->id}");
        $deleteResponse->assertRedirect('/admin/testimonials');
        $this->assertDatabaseMissing('testimonials', [
            'id' => $testimonial->id,
        ]);
    }

    /**
     * Admin can view, create, edit, and delete team members.
     */
    public function test_admin_can_manage_team_members(): void
    {
        $user = $this->createSuperAdmin();

        // 1. View team index
        $indexResponse = $this->actingAs($user)->get('/admin/team');
        $indexResponse->assertStatus(200);

        // 2. View create form
        $createResponse = $this->actingAs($user)->get('/admin/team/create');
        $createResponse->assertStatus(200);

        // 3. Store new team member
        $storeResponse = $this->actingAs($user)->post('/admin/team', [
            'name' => 'মীর সাব্বির',
            'slug' => 'mir-sabbir',
            'designation' => 'সফটওয়্যার ইঞ্জিনিয়ার',
            'bio' => 'ফুল-স্ট্যাক ওয়েব ডেভেলপার এবং আর্কিটেক্ট।',
            'facebook' => 'https://facebook.com/mirsabbir',
            'linkedin' => 'https://linkedin.com/in/mirsabbir',
            'order' => 1,
            'is_active' => 1,
        ]);

        $storeResponse->assertRedirect('/admin/team');
        $this->assertDatabaseHas('team_members', [
            'name' => 'মীর সাব্বির',
            'slug' => 'mir-sabbir',
            'designation' => 'সফটওয়্যার ইঞ্জিনিয়ার',
        ]);

        $member = TeamMember::where('slug', 'mir-sabbir')->firstOrFail();

        // 4. View edit form
        $editResponse = $this->actingAs($user)->get("/admin/team/{$member->id}/edit");
        $editResponse->assertStatus(200);
        $editResponse->assertSee('মীর সাব্বির');

        // 5. Update team member
        $updateResponse = $this->actingAs($user)->put("/admin/team/{$member->id}", [
            'name' => 'মীর সাব্বির আহমেদ',
            'slug' => 'mir-sabbir-ahmed',
            'designation' => 'লিড সফটওয়্যার ইঞ্জিনিয়ার',
            'bio' => 'আপডেটেড বায়ো বিবরণী।',
            'order' => 2,
            'is_active' => 1,
        ]);

        $updateResponse->assertRedirect('/admin/team');
        $this->assertDatabaseHas('team_members', [
            'id' => $member->id,
            'name' => 'মীর সাব্বির আহমেদ',
            'slug' => 'mir-sabbir-ahmed',
            'designation' => 'লিড সফটওয়্যার ইঞ্জিনিয়ার',
        ]);

        // 6. Delete team member
        $deleteResponse = $this->actingAs($user)->delete("/admin/team/{$member->id}");
        $deleteResponse->assertRedirect('/admin/team');
        $this->assertDatabaseMissing('team_members', [
            'id' => $member->id,
        ]);
    }

    /**
     * Admin can view, create, edit, and delete achievements.
     */
    public function test_admin_can_manage_achievements(): void
    {
        $user = $this->createSuperAdmin();

        // 1. View achievements index
        $indexResponse = $this->actingAs($user)->get('/admin/achievements');
        $indexResponse->assertStatus(200);

        // 2. View create form
        $createResponse = $this->actingAs($user)->get('/admin/achievements/create');
        $createResponse->assertStatus(200);

        // 3. Store new achievement
        $storeResponse = $this->actingAs($user)->post('/admin/achievements', [
            'title' => 'আন্তর্জাতিক ক্লায়েন্ট',
            'count' => '120',
            'suffix' => '+',
            'icon' => 'fas fa-globe',
            'order' => 1,
            'is_active' => 1,
        ]);

        $storeResponse->assertRedirect('/admin/achievements');
        $this->assertDatabaseHas('achievements', [
            'title' => 'আন্তর্জাতিক ক্লায়েন্ট',
            'count' => '120',
            'icon' => 'fas fa-globe',
        ]);

        $achievement = Achievement::where('title', 'আন্তর্জাতিক ক্লায়েন্ট')->firstOrFail();

        // 4. View edit form
        $editResponse = $this->actingAs($user)->get("/admin/achievements/{$achievement->id}/edit");
        $editResponse->assertStatus(200);
        $editResponse->assertSee('আন্তর্জাতিক ক্লায়েন্ট');

        // 5. Update achievement
        $updateResponse = $this->actingAs($user)->put("/admin/achievements/{$achievement->id}", [
            'title' => 'গ্লোবাল পার্টনার',
            'count' => '150',
            'suffix' => '+',
            'icon' => 'fas fa-handshake',
            'order' => 2,
            'is_active' => 1,
        ]);

        $updateResponse->assertRedirect('/admin/achievements');
        $this->assertDatabaseHas('achievements', [
            'id' => $achievement->id,
            'title' => 'গ্লোবাল পার্টনার',
            'count' => '150',
            'icon' => 'fas fa-handshake',
        ]);

        // 6. Delete achievement
        $deleteResponse = $this->actingAs($user)->delete("/admin/achievements/{$achievement->id}");
        $deleteResponse->assertRedirect('/admin/achievements');
        $this->assertDatabaseMissing('achievements', [
            'id' => $achievement->id,
        ]);
    }

    /**
     * Admin can view, create, edit, and delete packages.
     */
    public function test_admin_can_manage_packages(): void
    {
        $user = $this->createSuperAdmin();

        // 1. View packages index
        $indexResponse = $this->actingAs($user)->get('/admin/packages');
        $indexResponse->assertStatus(200);

        // 2. View create form
        $createResponse = $this->actingAs($user)->get('/admin/packages/create');
        $createResponse->assertStatus(200);

        // 3. Store new package
        $storeResponse = $this->actingAs($user)->post('/admin/packages', [
            'name' => 'নিউজ পোর্টাল প্যাকেজ',
            'slug' => 'news-portal-package',
            'price' => '12000',
            'currency' => '৳',
            'period' => '/৫ দিনের মধ্যে ডেলিভারি',
            'features_text' => "লারাভেল ১০/১১ ব্যাকএন্ড\n১০০% মোবাইল ফ্রেন্ডলি\nx কোনো হিডেন চার্জ নেই",
            'button_text' => 'অর্ডার করুন',
            'button_url' => '',
            'is_featured' => 1,
            'is_active' => 1,
            'order' => 1,
        ]);

        $storeResponse->assertRedirect('/admin/packages');
        $this->assertDatabaseHas('packages', [
            'name' => 'নিউজ পোর্টাল প্যাকেজ',
            'slug' => 'news-portal-package',
            'price' => '12000',
            'is_featured' => 1,
        ]);

        $package = Package::where('slug', 'news-portal-package')->firstOrFail();
        $this->assertCount(3, $package->features);

        // 4. View edit form
        $editResponse = $this->actingAs($user)->get("/admin/packages/{$package->id}/edit");
        $editResponse->assertStatus(200);
        $editResponse->assertSee('নিউজ পোর্টাল প্যাকেজ');

        // 5. Update package
        $updateResponse = $this->actingAs($user)->put("/admin/packages/{$package->id}", [
            'name' => 'নিউজ পোর্টাল প্রো প্যাকেজ',
            'slug' => 'news-portal-package',
            'price' => '15000',
            'currency' => '৳',
            'period' => '/৩ দিনের মধ্যে ডেলিভারি',
            'features_text' => "লারাভেল ব্যাকএন্ড\nফ্রি ডোমেন ও হোস্টিং",
            'button_text' => 'এখনই নিন',
            'button_url' => 'https://wa.me/8801849832178',
            'is_featured' => 0,
            'is_active' => 1,
            'order' => 2,
        ]);

        $updateResponse->assertRedirect('/admin/packages');
        $this->assertDatabaseHas('packages', [
            'id' => $package->id,
            'name' => 'নিউজ পোর্টাল প্রো প্যাকেজ',
            'price' => '15000',
            'button_text' => 'এখনই নিন',
        ]);

        // 6. Delete package
        $deleteResponse = $this->actingAs($user)->delete("/admin/packages/{$package->id}");
        $deleteResponse->assertRedirect('/admin/packages');
        $this->assertDatabaseMissing('packages', [
            'id' => $package->id,
        ]);
    }

    /**
     * Admin can view, create, edit, and delete admin accounts with role assignment.
     */
    public function test_admin_can_manage_admin_users(): void
    {
        $superAdmin = $this->createSuperAdmin([
            'name' => 'Super Admin',
            'email' => 'super@akhitech.com',
        ]);

        // 1. View admins index
        $indexResponse = $this->actingAs($superAdmin)->get('/admin/admins');
        $indexResponse->assertStatus(200);
        $indexResponse->assertSee('Super Admin');
        $indexResponse->assertSee('super@akhitech.com');

        // 2. View create form
        $createResponse = $this->actingAs($superAdmin)->get('/admin/admins/create');
        $createResponse->assertStatus(200);

        // 3. Store new admin with role
        $storeResponse = $this->actingAs($superAdmin)->post('/admin/admins', [
            'name' => 'New Manager',
            'email' => 'manager@akhitech.com',
            'password' => 'Secret@12345',
            'password_confirmation' => 'Secret@12345',
            'roles' => ['Editor'],
        ]);

        $storeResponse->assertRedirect('/admin/admins');
        $this->assertDatabaseHas('users', [
            'name' => 'New Manager',
            'email' => 'manager@akhitech.com',
        ]);

        $newAdmin = User::where('email', 'manager@akhitech.com')->firstOrFail();
        $this->assertTrue($newAdmin->hasRole('Editor'));

        // 4. View edit form
        $editResponse = $this->actingAs($superAdmin)->get("/admin/admins/{$newAdmin->id}/edit");
        $editResponse->assertStatus(200);
        $editResponse->assertSee('New Manager');

        // 5. Update admin
        $updateResponse = $this->actingAs($superAdmin)->put("/admin/admins/{$newAdmin->id}", [
            'name' => 'Senior Manager',
            'email' => 'seniormanager@akhitech.com',
            'password' => '',
            'password_confirmation' => '',
            'roles' => ['Editor'],
        ]);

        $updateResponse->assertRedirect('/admin/admins');
        $this->assertDatabaseHas('users', [
            'id' => $newAdmin->id,
            'name' => 'Senior Manager',
            'email' => 'seniormanager@akhitech.com',
        ]);

        // 6. Cannot delete self
        $deleteSelfResponse = $this->actingAs($superAdmin)->delete("/admin/admins/{$superAdmin->id}");
        $deleteSelfResponse->assertRedirect('/admin/admins');
        $this->assertDatabaseHas('users', ['id' => $superAdmin->id]);

        // 7. Delete other admin
        $deleteOtherResponse = $this->actingAs($superAdmin)->delete("/admin/admins/{$newAdmin->id}");
        $deleteOtherResponse->assertRedirect('/admin/admins');
        $this->assertDatabaseMissing('users', ['id' => $newAdmin->id]);
    }

    /**
     * User without permissions cannot access protected admin routes.
     */
    public function test_user_without_permissions_receives_403_forbidden(): void
    {
        $unprivilegedUser = User::factory()->create();

        // Attempt accessing services index
        $this->actingAs($unprivilegedUser)->get('/admin/services')->assertStatus(403);

        // Attempt accessing packages index
        $this->actingAs($unprivilegedUser)->get('/admin/packages')->assertStatus(403);

        // Attempt accessing settings
        $this->actingAs($unprivilegedUser)->get('/admin/settings')->assertStatus(403);

        // Attempt accessing admin users
        $this->actingAs($unprivilegedUser)->get('/admin/admins')->assertStatus(403);

        // Attempt accessing roles
        $this->actingAs($unprivilegedUser)->get('/admin/roles')->assertStatus(403);
    }

    /**
     * User with custom role can only access allowed modules.
     */
    public function test_user_with_specific_permission_can_only_access_permitted_modules(): void
    {
        $customRole = Role::create(['name' => 'Service Only Manager', 'guard_name' => 'web']);
        $customRole->givePermissionTo(['services.view', 'services.create']);

        $serviceManager = User::factory()->create();
        $serviceManager->assignRole($customRole);

        // Can view services
        $response = $this->actingAs($serviceManager)->get('/admin/services');
        $response->assertStatus(200);

        // Can view create service
        $createResponse = $this->actingAs($serviceManager)->get('/admin/services/create');
        $createResponse->assertStatus(200);

        // Cannot access packages (403)
        $this->actingAs($serviceManager)->get('/admin/packages')->assertStatus(403);

        // Cannot access roles (403)
        $this->actingAs($serviceManager)->get('/admin/roles')->assertStatus(403);

        // Cannot access settings (403)
        $this->actingAs($serviceManager)->get('/admin/settings')->assertStatus(403);
    }

    /**
     * Super Admin can manage roles and permissions.
     */
    public function test_super_admin_can_manage_roles_and_permissions(): void
    {
        $superAdmin = $this->createSuperAdmin();

        // 1. View roles list
        $indexResponse = $this->actingAs($superAdmin)->get('/admin/roles');
        $indexResponse->assertStatus(200);
        $indexResponse->assertSee('সুপার এডমিন');

        // 2. View create role page
        $createResponse = $this->actingAs($superAdmin)->get('/admin/roles/create');
        $createResponse->assertStatus(200);
        $createResponse->assertSee('রোলের নাম');

        // 3. Store new role
        $storeResponse = $this->actingAs($superAdmin)->post('/admin/roles', [
            'name' => 'Support Agent',
            'permissions' => ['inquiries.view', 'inquiries.delete'],
        ]);

        $storeResponse->assertRedirect('/admin/roles');
        $this->assertDatabaseHas('roles', ['name' => 'Support Agent']);

        $newRole = Role::where('name', 'Support Agent')->firstOrFail();
        $this->assertTrue($newRole->hasPermissionTo('inquiries.view'));
        $this->assertTrue($newRole->hasPermissionTo('inquiries.delete'));
        $this->assertFalse($newRole->hasPermissionTo('services.create'));

        // 4. View edit role page
        $editResponse = $this->actingAs($superAdmin)->get("/admin/roles/{$newRole->id}/edit");
        $editResponse->assertStatus(200);
        $editResponse->assertSee('Support Agent');

        // 5. Update role
        $updateResponse = $this->actingAs($superAdmin)->put("/admin/roles/{$newRole->id}", [
            'name' => 'Customer Care Officer',
            'permissions' => ['inquiries.view'],
        ]);

        $updateResponse->assertRedirect('/admin/roles');
        $this->assertDatabaseHas('roles', ['name' => 'Customer Care Officer']);

        $newRole->refresh();
        $this->assertTrue($newRole->hasPermissionTo('inquiries.view'));
        $this->assertFalse($newRole->hasPermissionTo('inquiries.delete'));

        // 6. Delete custom role
        $deleteResponse = $this->actingAs($superAdmin)->delete("/admin/roles/{$newRole->id}");
        $deleteResponse->assertRedirect('/admin/roles');
        $this->assertDatabaseMissing('roles', ['id' => $newRole->id]);
    }

    /**
     * Super Admin role cannot be deleted.
     */
    public function test_super_admin_role_cannot_be_deleted(): void
    {
        $superAdminUser = $this->createSuperAdmin();
        $superAdminRole = Role::where('name', 'Super Admin')->firstOrFail();

        $response = $this->actingAs($superAdminUser)->delete("/admin/roles/{$superAdminRole->id}");
        $response->assertRedirect('/admin/roles');
        $response->assertSessionHas('error');
        $this->assertDatabaseHas('roles', ['name' => 'Super Admin']);
    }

    /**
     * Test login rate limiting and brute force protection.
     */
    public function test_login_rate_limiting_and_brute_force_protection(): void
    {
        $user = $this->createSuperAdmin([
            'email' => 'victim@akhitech.com',
            'password' => bcrypt('Correct@Password123'),
        ]);

        // 5 consecutive failed login attempts
        for ($i = 0; $i < 5; $i++) {
            $response = $this->from('/admin/login')->post('/admin/login', [
                'email' => 'victim@akhitech.com',
                'password' => 'wrongpassword',
            ]);
            $response->assertRedirect('/admin/login');
            $response->assertSessionHas('error');
        }

        // 6th attempt should be blocked by RateLimiter
        $blockedResponse = $this->from('/admin/login')->post('/admin/login', [
            'email' => 'victim@akhitech.com',
            'password' => 'wrongpassword',
        ]);

        $blockedResponse->assertRedirect('/admin/login');
        $this->assertDatabaseHas('login_activities', [
            'email' => 'victim@akhitech.com',
            'status' => 'locked',
        ]);
    }

    /**
     * Test login activities are recorded on success and failure.
     */
    public function test_login_activity_recording_and_viewing(): void
    {
        $superAdmin = $this->createSuperAdmin([
            'email' => 'logger@akhitech.com',
            'password' => bcrypt('Strong@Secret123'),
        ]);

        // Failed attempt
        $this->post('/admin/login', [
            'email' => 'logger@akhitech.com',
            'password' => 'wrongpass',
        ]);

        $this->assertDatabaseHas('login_activities', [
            'email' => 'logger@akhitech.com',
            'status' => 'failed',
        ]);

        // Successful attempt
        $this->post('/admin/login', [
            'email' => 'logger@akhitech.com',
            'password' => 'Strong@Secret123',
        ]);

        $this->assertDatabaseHas('login_activities', [
            'email' => 'logger@akhitech.com',
            'status' => 'successful',
        ]);

        // Super Admin can view login activities page
        $viewResponse = $this->actingAs($superAdmin)->get('/admin/login-activities');
        $viewResponse->assertStatus(200);
        $viewResponse->assertSee('logger@akhitech.com');
    }

    /**
     * Test admin force logout terminates user sessions.
     */
    public function test_force_logout_terminates_admin_sessions(): void
    {
        $superAdmin = $this->createSuperAdmin();
        $targetUser = User::factory()->create();

        // Simulate active session in sessions table
        DB::table('sessions')->insert([
            'id' => 'test_session_id_123',
            'user_id' => $targetUser->id,
            'ip_address' => '127.0.0.1',
            'user_agent' => 'Mozilla/5.0 Test Browser',
            'payload' => base64_encode(serialize(['_token' => 'abc'])),
            'last_activity' => time(),
        ]);

        $this->assertDatabaseHas('sessions', ['id' => 'test_session_id_123']);

        // Force logout the target user
        $response = $this->actingAs($superAdmin)->post("/admin/admins/{$targetUser->id}/force-logout");
        $response->assertRedirect('/admin/admins');

        $this->assertDatabaseMissing('sessions', ['id' => 'test_session_id_123']);
    }

    /**
     * Test strong password policy validation rejects weak passwords.
     */
    public function test_strong_password_policy_rejects_weak_passwords(): void
    {
        $superAdmin = $this->createSuperAdmin();

        // 1. Password without mixedCase and symbols (fails)
        $weakResponse = $this->actingAs($superAdmin)->post('/admin/admins', [
            'name' => 'Weak User',
            'email' => 'weak@example.com',
            'password' => 'weakpassword123',
            'password_confirmation' => 'weakpassword123',
        ]);
        $weakResponse->assertSessionHasErrors('password');

        // 2. Strong password with lowercase, uppercase, numbers and symbols (succeeds)
        $strongResponse = $this->actingAs($superAdmin)->post('/admin/admins', [
            'name' => 'Strong User',
            'email' => 'strong@example.com',
            'password' => 'Strong#Admin999!',
            'password_confirmation' => 'Strong#Admin999!',
        ]);
        $strongResponse->assertRedirect('/admin/admins');
        $this->assertDatabaseHas('users', ['email' => 'strong@example.com']);
    }
}
