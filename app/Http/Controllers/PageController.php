<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Achievement;
use App\Models\Inquiry;
use App\Models\Package;
use App\Models\Page;
use App\Models\Portfolio;
use App\Models\Post;
use App\Models\Service;
use App\Models\Subscriber;
use App\Models\TeamMember;
use App\Models\Testimonial;
use App\Services\SitemapService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Illuminate\View\View;

class PageController extends Controller
{
    /**
     * Display the home page with dynamic services, portfolios, blogs, testimonials, team, and achievements.
     */
    public function home(): View
    {
        $services = Service::where('is_active', true)->orderBy('order')->take(4)->get();
        $portfolios = Portfolio::where('is_active', true)->take(6)->get();
        $posts = Post::where('is_published', true)->latest('published_at')->take(3)->get();
        $testimonials = Testimonial::where('is_active', true)->orderBy('order')->latest()->get();
        $teamMembers = TeamMember::where('is_active', true)->orderBy('order')->get();
        $achievements = Achievement::where('is_active', true)->orderBy('order')->get();

        return view('pages.home', compact('services', 'portfolios', 'posts', 'testimonials', 'teamMembers', 'achievements'));
    }

    /**
     * Display the about page with company details, achievements, and team members.
     */
    public function about(): View
    {
        $teamMembers = TeamMember::where('is_active', true)->orderBy('order')->get();
        $achievements = Achievement::where('is_active', true)->orderBy('order')->get();

        return view('pages.about', compact('teamMembers', 'achievements'));
    }

    /**
     * Display the services catalog page.
     */
    public function services(): View
    {
        $services = Service::where('is_active', true)->orderBy('order')->get();

        return view('pages.services', compact('services'));
    }

    /**
     * Display the packages/pricing catalog page.
     */
    public function packages(): View
    {
        $packages = Package::where('is_active', true)->orderBy('order')->latest()->get();

        return view('pages.packages', compact('packages'));
    }

    /**
     * Display the portfolio showcase page.
     */
    public function portfolio(): View
    {
        $portfolios = Portfolio::where('is_active', true)->latest()->get();

        return view('pages.portfolio', compact('portfolios'));
    }

    /**
     * Display a single portfolio project details page.
     */
    public function portfolioDetails(string $slug): View
    {
        $portfolio = Portfolio::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $relatedPortfolios = Portfolio::where('id', '!=', $portfolio->id)
            ->where('is_active', true)
            ->latest()
            ->take(6)
            ->get();

        return view('pages.portfolio-details', compact('portfolio', 'relatedPortfolios'));
    }

    /**
     * Display the blog listing page.
     */
    public function blog(): View
    {
        $posts = Post::where('is_published', true)->latest('published_at')->paginate(9);

        return view('pages.blog', compact('posts'));
    }

    /**
     * Display a single blog post details page.
     */
    public function blogDetails(string $slug): View
    {
        $post = Post::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        $recentPosts = Post::where('is_published', true)
            ->where('id', '!=', $post->id)
            ->latest('published_at')
            ->take(5)
            ->get();

        return view('pages.blog-details', compact('post', 'recentPosts'));
    }

    /**
     * Display the contact page.
     */
    public function contact(): View
    {
        return view('pages.contact');
    }

    /**
     * Display the free consultation / quote page.
     */
    public function quote(): View
    {
        return view('pages.quote');
    }

    /**
     * Display the privacy policy page.
     */
    public function privacy(): View
    {
        return view('pages.privacy');
    }

    /**
     * Display the terms and conditions page.
     */
    public function terms(): View
    {
        return view('pages.terms');
    }

    /**
     * Display a dynamic custom page by its slug.
     */
    public function showPage(string $slug): View
    {
        $page = Page::where('slug', $slug)
            ->where('is_active', true)
            ->with('parent')
            ->firstOrFail();

        return view('pages.custom', compact('page'));
    }

    /**
     * Generate dynamic XML sitemap for SEO and search engine crawlers.
     */
    public function sitemap(): Response
    {
        $filePath = public_path('sitemap.xml');

        if (! app()->environment('testing') && File::exists($filePath)) {
            return response(File::get($filePath), 200)
                ->header('Content-Type', 'text/xml');
        }

        $xml = SitemapService::renderXml();

        return response($xml, 200)
            ->header('Content-Type', 'text/xml');
    }

    /**
     * Handle newsletter subscription and persist to database.
     */
    public function newsletterStore(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email', 'max:255'],
        ], [
            'email.required' => 'অনুগ্রহ করে আপনার ইমেইল প্রদান করুন।',
            'email.email' => 'সঠিক ইমেইল এড্রেস লিখুন।',
        ]);

        Subscriber::firstOrCreate(
            ['email' => $validated['email']],
            ['subscribed_at' => now()]
        );

        return back()->with('newsletter_success', 'আমাদের নিউজলেটারে সাবস্ক্রাইব করার জন্য ধন্যবাদ!');
    }

    /**
     * Handle contact form submission and persist to database.
     */
    public function contactSubmit(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:3000'],
        ], [
            'name.required' => 'আপনার নাম লিখুন।',
            'email.required' => 'আপনার ইমেইল লিখুন।',
            'email.email' => 'সঠিক ইমেইল দিন।',
            'subject.required' => 'বিষয় লিখুন।',
            'message.required' => 'আপনার বার্তা লিখুন।',
        ]);

        Inquiry::create(array_merge($validated, ['type' => 'contact']));

        return back()->with('success', 'আপনার বার্তা সফলভাবে গ্রহণ করা হয়েছে। আমরা শীঘ্রই যোগাযোগ করব।');
    }

    /**
     * Handle quote / consultation form submission and persist to database.
     */
    public function quoteSubmit(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:3000'],
        ], [
            'name.required' => 'আপনার নাম লিখুন।',
            'email.required' => 'আপনার ইমেইল লিখুন।',
            'email.email' => 'সঠিক ইমেইল দিন।',
            'subject.required' => 'প্রজেক্টের ধরন লিখুন।',
            'message.required' => 'প্রজেক্টের বিবরণ লিখুন।',
        ]);

        Inquiry::create(array_merge($validated, ['type' => 'quote']));

        return back()->with('success', 'আপনার কনসালটেশন রিকোয়েস্ট সফলভাবে জমা হয়েছে। আমাদের টিম দ্রুত আপনার সাথে যোগাযোগ করবে।');
    }
}
