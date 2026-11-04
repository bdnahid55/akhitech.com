<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use App\Models\Portfolio;
use App\Models\Post;
use App\Models\Service;
use App\Models\Subscriber;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard with overview statistics.
     */
    public function index(): View
    {
        $stats = [
            'services' => Service::count(),
            'portfolios' => Portfolio::count(),
            'posts' => Post::count(),
            'inquiries' => Inquiry::count(),
            'unread_inquiries' => Inquiry::where('is_read', false)->count(),
            'subscribers' => Subscriber::count(),
        ];

        $recentInquiries = Inquiry::latest()->take(6)->get();
        $recentPosts = Post::latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentInquiries', 'recentPosts'));
    }
}
