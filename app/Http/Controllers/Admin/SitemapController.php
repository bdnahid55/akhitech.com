<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\SitemapService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class SitemapController extends Controller
{
    /**
     * Display the SEO XML Sitemap management interface.
     */
    public function index(): View
    {
        Gate::authorize('settings.view');

        $status = SitemapService::getStatus();
        $entries = SitemapService::getAllEntries();

        return view('admin.sitemap.index', compact('status', 'entries'));
    }

    /**
     * Generate or update the physical sitemap.xml file.
     */
    public function generate(): RedirectResponse
    {
        Gate::authorize('settings.edit');

        $result = SitemapService::generateFile();

        return redirect()->route('admin.sitemap.index')
            ->with('success', "সাইটম্যাপ সফলভাবে জেনারেট ও আপডেট হয়েছে! মোট {$result['total_urls']} টি URL সাইটম্যাপে যুক্ত করা হয়েছে ({$result['file_size']})।");
    }

    /**
     * Download the physical sitemap.xml file.
     */
    public function download(): BinaryFileResponse
    {
        Gate::authorize('settings.view');

        $filePath = public_path('sitemap.xml');

        if (! File::exists($filePath)) {
            SitemapService::generateFile();
        }

        return response()->download($filePath, 'sitemap.xml', [
            'Content-Type' => 'text/xml',
        ]);
    }
}
