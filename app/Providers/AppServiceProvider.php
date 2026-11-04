<?php

namespace App\Providers;

use App\Models\Page;
use App\Models\Setting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Share dynamic navigation and site settings with all views
        View::composer('*', function ($view): void {
            if (Schema::hasTable('settings') && Schema::hasTable('pages')) {
                $siteSettings = Setting::getAll();

                $headerPages = Page::query()
                    ->where('is_active', true)
                    ->where('show_in_header', true)
                    ->whereNull('header_parent_id')
                    ->with(['children' => fn ($q) => $q->where('is_active', true)->orderBy('order')])
                    ->orderBy('order')
                    ->get();

                $footerQuickPages = Page::query()
                    ->where('is_active', true)
                    ->where('show_in_footer', true)
                    ->where('footer_column', 'quick_links')
                    ->orderBy('order')
                    ->get();

                $footerLegalPages = Page::query()
                    ->where('is_active', true)
                    ->where('show_in_footer', true)
                    ->where('footer_column', 'legal')
                    ->orderBy('order')
                    ->get();

                $view->with(compact('siteSettings', 'headerPages', 'footerQuickPages', 'footerLegalPages'));
            }
        });
    }
}
