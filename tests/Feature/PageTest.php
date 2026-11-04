<?php

namespace Tests\Feature;

use App\Models\Achievement;
use App\Models\Page;
use App\Models\Portfolio;
use App\Models\Post;
use App\Models\Service;
use App\Models\TeamMember;
use App\Models\Testimonial;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PageTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test all static and dynamic frontend routes return 200 OK.
     */
    public function test_frontend_pages_are_accessible_and_render_dynamic_content(): void
    {
        Service::factory()->count(3)->create(['is_active' => true]);
        Portfolio::factory()->count(3)->create(['is_active' => true]);
        Post::factory()->count(3)->create(['is_published' => true]);
        TeamMember::factory()->count(2)->create(['is_active' => true]);
        Achievement::factory()->count(2)->create(['is_active' => true]);

        $routes = [
            '/',
            '/about',
            '/services',
            '/team',
            '/portfolio',
            '/blog',
            '/contact',
            '/get-quote',
            '/privacy-policy',
            '/terms-and-conditions',
        ];

        foreach ($routes as $route) {
            $response = $this->get($route);
            $response->assertStatus(200);
        }
    }

    /**
     * Test portfolio details page renders with project info and related projects.
     */
    public function test_portfolio_details_page_renders_successfully(): void
    {
        $portfolio = Portfolio::factory()->create([
            'title' => 'Source the products',
            'slug' => 'source-the-products',
            'category' => 'ওয়েব ডিজাইন ও ডেভেলপমেন্ট',
            'client_name' => 'Source Ltd',
            'start_date' => '01/15/2025',
            'end_date' => '02/10/2025',
            'project_url' => 'https://www.sourcetheproducts.com',
            'description' => '<p>আন্তর্জাতিক পণ্য সোর্সিং প্ল্যাটফর্ম।</p>',
            'is_active' => true,
        ]);

        $related = Portfolio::factory()->create([
            'title' => 'AJker Bazar',
            'slug' => 'ajker-bazar',
            'is_active' => true,
        ]);

        $response = $this->get('/portfolio/source-the-products');
        $response->assertStatus(200);
        $response->assertSee('Source the products');
        $response->assertSee('Source Ltd');
        $response->assertSee('01/15/2025');
        $response->assertSee('02/10/2025');
        $response->assertSee('https://www.sourcetheproducts.com');
        $response->assertSee('আন্তর্জাতিক পণ্য সোর্সিং প্ল্যাটফর্ম', false);
        $response->assertSee('AJker Bazar');
    }

    /**
     * Test blog post details page renders with author, content and recent posts.
     */
    public function test_blog_post_details_page_renders_successfully(): void
    {
        $post = Post::factory()->create([
            'title' => 'ইউআই ও ইউএক্স ডিজাইনের গুরুত্ব',
            'slug' => 'importance-of-ui-ux-design',
            'author' => 'টেক রাইটার',
            'content' => '<p>আধুনিক অ্যাপ্লিকেশনে ইউজার এক্সপেরিয়েন্স অপরিহার্য।</p>',
            'excerpt' => 'ইউআই ও ইউএক্স নিয়ে বিস্তারিত আলোচনা।',
            'published_at' => now(),
            'is_published' => true,
        ]);

        $recent = Post::factory()->create([
            'title' => 'ডিজিটাল মার্কেটিং টিপস',
            'slug' => 'digital-marketing-tips',
            'is_published' => true,
        ]);

        $response = $this->get('/blog/importance-of-ui-ux-design');
        $response->assertStatus(200);
        $response->assertSee('ইউআই ও ইউএক্স ডিজাইনের গুরুত্ব');
        $response->assertSee('টেক রাইটার');
        $response->assertSee('আধুনিক অ্যাপ্লিকেশনে ইউজার এক্সপেরিয়েন্স অপরিহার্য', false);
        $response->assertSee('ডিজিটাল মার্কেটিং টিপস');
    }

    /**
     * Test custom dynamic page renders with proper SEO tags.
     */
    public function test_custom_dynamic_page_is_accessible_and_renders_seo_tags(): void
    {
        $page = Page::factory()->create([
            'title' => 'আমাদের ক্যারিয়ার',
            'slug' => 'our-careers',
            'content' => '<p>আমাদের সাথে যুক্ত হতে আপনার সিভি পাঠান।</p>',
            'meta_title' => 'ক্যারিয়ার সুযোগ | আখিটেক',
            'meta_description' => 'আখিটেক প্রতিষ্ঠানে বিভিন্ন পদে নিয়োগ চলছে।',
            'meta_keywords' => 'career, job, akhitech',
            'canonical_url' => 'http://localhost/page/our-careers',
            'is_active' => true,
        ]);

        $response = $this->get('/page/our-careers');
        $response->assertStatus(200);
        $response->assertSee('আমাদের ক্যারিয়ার');
        $response->assertSee('আমাদের সাথে যুক্ত হতে আপনার সিভি পাঠান', false);
        $response->assertSee('ক্যারিয়ার সুযোগ | আখিটেক');
        $response->assertSee('আখিটেক প্রতিষ্ঠানে বিভিন্ন পদে নিয়োগ চলছে।');
        $response->assertSee('career, job, akhitech');
        $response->assertSee('http://localhost/page/our-careers');
    }

    /**
     * Test dynamic pages render in header and footer menus.
     */
    public function test_dynamic_pages_render_in_header_and_footer_menus(): void
    {
        $parentHeaderPage = Page::factory()->create([
            'title' => 'কোম্পানি ইনফো',
            'slug' => 'company-info',
            'show_in_header' => true,
            'is_active' => true,
        ]);

        $childHeaderPage = Page::factory()->create([
            'title' => 'আমাদের অর্জন',
            'slug' => 'our-achievements',
            'header_parent_id' => $parentHeaderPage->id,
            'show_in_header' => true,
            'is_active' => true,
        ]);

        $footerQuickPage = Page::factory()->create([
            'title' => 'সাপোর্ট সেন্টার',
            'slug' => 'support-center',
            'show_in_footer' => true,
            'footer_column' => 'quick_links',
            'is_active' => true,
        ]);

        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('কোম্পানি ইনফো');
        $response->assertSee('আমাদের অর্জন');
        $response->assertSee('সাপোর্ট সেন্টার');
    }

    /**
     * Test sitemap XML generation.
     */
    public function test_sitemap_xml_renders_valid_xml_with_all_pages(): void
    {
        Page::factory()->create([
            'title' => 'টেস্ট পেজ',
            'slug' => 'test-sitemap-page',
            'is_active' => true,
        ]);

        $response = $this->get('/sitemap.xml');
        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'text/xml; charset=UTF-8');
        $response->assertSee('urlset', false);
        $response->assertSee('test-sitemap-page');
    }

    /**
     * Test contact form submission validation.
     */
    public function test_contact_form_requires_valid_data(): void
    {
        $response = $this->post('/contact/submit', []);
        $response->assertSessionHasErrors(['name', 'email', 'subject', 'message']);
    }

    /**
     * Test contact form submits successfully and persists to database.
     */
    public function test_contact_form_submits_successfully_and_saves_to_database(): void
    {
        $response = $this->post('/contact/submit', [
            'name' => 'Nazmul',
            'email' => 'nazmul@example.com',
            'phone' => '01849832178',
            'subject' => 'Website Inquiry',
            'message' => 'I would like to develop a custom website.',
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('inquiries', [
            'type' => 'contact',
            'email' => 'nazmul@example.com',
            'name' => 'Nazmul',
        ]);
    }

    /**
     * Test quote form submission validation and saves to database.
     */
    public function test_quote_form_submits_successfully_and_saves_to_database(): void
    {
        $response = $this->post('/get-quote/submit', [
            'name' => 'Rahim',
            'email' => 'rahim@example.com',
            'phone' => '01700000000',
            'subject' => 'E-commerce Platform',
            'message' => 'Need an online shop with payment gateway.',
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('inquiries', [
            'type' => 'quote',
            'email' => 'rahim@example.com',
            'subject' => 'E-commerce Platform',
        ]);
    }

    /**
     * Test newsletter subscription saves to database.
     */
    public function test_newsletter_subscribes_successfully_and_saves_to_database(): void
    {
        $response = $this->post('/newsletter/subscribe', [
            'email' => 'subscriber@example.com',
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $response->assertSessionHas('newsletter_success');

        $this->assertDatabaseHas('subscribers', [
            'email' => 'subscriber@example.com',
        ]);
    }

    /**
     * Test homepage renders dynamic testimonials correctly.
     */
    public function test_homepage_renders_dynamic_testimonials(): void
    {
        Testimonial::factory()->create([
            'name' => 'ফাতেমা আক্তার',
            'designation' => 'উদ্যোক্তা',
            'comment' => 'আমরা আমাদের নতুন ওয়েবসাইটের সমস্ত দিক নিয়ে খুব মুগ্ধ হয়েছি।',
            'rating' => 5,
            'is_active' => true,
        ]);

        Testimonial::factory()->create([
            'name' => 'লুকানো ব্যক্তি',
            'is_active' => false,
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('ফাতেমা আক্তার');
        $response->assertSee('উদ্যোক্তা');
        $response->assertSee('আমরা আমাদের নতুন ওয়েবসাইটের সমস্ত দিক নিয়ে খুব মুগ্ধ হয়েছি।');
        $response->assertDontSee('লুকানো ব্যক্তি');
    }

    /**
     * Test homepage and about page render dynamic team members correctly.
     */
    public function test_homepage_and_about_render_dynamic_team_members(): void
    {
        $member = TeamMember::factory()->create([
            'name' => 'Md Nazrul Islam (Sayed)',
            'designation' => 'CEO',
            'is_active' => true,
        ]);

        $inactiveMember = TeamMember::factory()->create([
            'name' => 'লুকানো টিম মেম্বার',
            'is_active' => false,
        ]);

        // 1. Homepage
        $homeResponse = $this->get('/');
        $homeResponse->assertStatus(200);
        $homeResponse->assertSee('Md Nazrul Islam (Sayed)');
        $homeResponse->assertSee('CEO');
        $homeResponse->assertDontSee('লুকানো টিম মেম্বার');

        // 2. About page
        $aboutResponse = $this->get('/about');
        $aboutResponse->assertStatus(200);
        $aboutResponse->assertSee('Md Nazrul Islam (Sayed)');
        $aboutResponse->assertSee('CEO');
        $aboutResponse->assertDontSee('লুকানো টিম মেম্বার');
    }

    /**
     * Test homepage and about page render dynamic achievements correctly.
     */
    public function test_homepage_and_about_render_dynamic_achievements(): void
    {
        Achievement::factory()->create([
            'title' => 'কমপ্লিট প্রজেক্ট রেকর্ড',
            'count' => '568',
            'suffix' => '+',
            'is_active' => true,
        ]);

        Achievement::factory()->create([
            'title' => 'লুকানো অর্জন',
            'is_active' => false,
        ]);

        // 1. Homepage
        $homeResponse = $this->get('/');
        $homeResponse->assertStatus(200);
        $homeResponse->assertSee('কমপ্লিট প্রজেক্ট রেকর্ড');
        $homeResponse->assertSee('568');
        $homeResponse->assertDontSee('লুকানো অর্জন');

        // 2. About page
        $aboutResponse = $this->get('/about');
        $aboutResponse->assertStatus(200);
        $aboutResponse->assertSee('কমপ্লিট প্রজেক্ট রেকর্ড');
        $aboutResponse->assertSee('568');
        $aboutResponse->assertDontSee('লুকানো অর্জন');
    }
}
