<?php

namespace Tests\Feature;

use App\Models\Inquiry;
use App\Models\Page;
use App\Models\Portfolio;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Subscriber;
use App\Models\TeamMember;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use RefreshDatabase;

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
        $user = User::factory()->create([
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
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/admin');
        $response->assertStatus(200);
        $response->assertSee('ড্যাশবোর্ড');
    }

    /**
     * Admin can create, edit, and delete a service.
     */
    public function test_admin_can_manage_services(): void
    {
        $user = User::factory()->create();

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
        $user = User::factory()->create();

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
        $user = User::factory()->create();
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
        $user = User::factory()->create();
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
        $user = User::factory()->create();

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
        $user = User::factory()->create();

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
        $this->assertEquals('+8801999999999', Setting::get('contact_phone'));
        $this->assertEquals('hello@akhitech.com', Setting::get('contact_email'));
    }

    /**
     * Admin can view, create, edit, and delete testimonials.
     */
    public function test_admin_can_manage_testimonials(): void
    {
        $user = User::factory()->create();

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
        $user = User::factory()->create();

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
}
