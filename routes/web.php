<?php

declare(strict_types=1);

use App\Http\Controllers\Admin\AchievementController as AdminAchievementController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\InquiryController as AdminInquiryController;
use App\Http\Controllers\Admin\LoginActivityController as AdminLoginActivityController;
use App\Http\Controllers\Admin\PackageController as AdminPackageController;
use App\Http\Controllers\Admin\PageController as AdminPageController;
use App\Http\Controllers\Admin\PortfolioController as AdminPortfolioController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\RoleController as AdminRoleController;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\Admin\SubscriberController as AdminSubscriberController;
use App\Http\Controllers\Admin\TeamMemberController as AdminTeamMemberController;
use App\Http\Controllers\Admin\TestimonialController as AdminTestimonialController;
use App\Http\Controllers\PageController;
use App\Http\Middleware\AdminInactivityTimeout;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Frontend Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/services', [PageController::class, 'services'])->name('services');
Route::get('/packages', [PageController::class, 'packages'])->name('packages');
Route::redirect('/package', '/packages');
Route::redirect('/page/packages', '/packages');
Route::get('/portfolio', [PageController::class, 'portfolio'])->name('portfolio');
Route::get('/portfolio/{slug}', [PageController::class, 'portfolioDetails'])->name('portfolio.show');
Route::get('/blog', [PageController::class, 'blog'])->name('blog');
Route::get('/blog/{slug}', [PageController::class, 'blogDetails'])->name('blog.show');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact/submit', [PageController::class, 'contactSubmit'])->name('contact.submit');
Route::get('/get-quote', [PageController::class, 'quote'])->name('quote');
Route::post('/get-quote/submit', [PageController::class, 'quoteSubmit'])->name('quote.submit');
Route::get('/privacy-policy', [PageController::class, 'privacy'])->name('privacy');
Route::get('/terms-and-conditions', [PageController::class, 'terms'])->name('terms');
Route::get('/sitemap.xml', [PageController::class, 'sitemap'])->name('sitemap');
Route::get('/page/{slug}', [PageController::class, 'showPage'])->name('page.show');
Route::post('/newsletter/subscribe', [PageController::class, 'newsletterStore'])->name('newsletter.store');

/*
|--------------------------------------------------------------------------
| Admin Authentication Routes (Custom Secure Portal)
|--------------------------------------------------------------------------
*/

Route::get('/secure-portal', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/secure-portal', [AdminAuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
Route::get('/login', fn () => redirect()->route('admin.login'))->name('login');

/*
|--------------------------------------------------------------------------
| Protected Admin Dashboard & Management Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', AdminInactivityTimeout::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Custom Pages CRUD
    Route::resource('pages', AdminPageController::class);

    // Services CRUD
    Route::resource('services', AdminServiceController::class);

    // Packages / Pricing CRUD
    Route::resource('packages', AdminPackageController::class);

    // Portfolios CRUD
    Route::resource('portfolios', AdminPortfolioController::class);

    // Blog Posts CRUD
    Route::resource('posts', AdminPostController::class);

    // Testimonials CRUD
    Route::resource('testimonials', AdminTestimonialController::class);

    // Team Members CRUD
    Route::resource('team', AdminTeamMemberController::class);

    // Achievements CRUD
    Route::resource('achievements', AdminAchievementController::class);

    // Inquiries & Messages
    Route::get('inquiries', [AdminInquiryController::class, 'index'])->name('inquiries.index');
    Route::get('inquiries/{inquiry}', [AdminInquiryController::class, 'show'])->name('inquiries.show');
    Route::delete('inquiries/{inquiry}', [AdminInquiryController::class, 'destroy'])->name('inquiries.destroy');

    // Newsletter Subscribers
    Route::get('subscribers', [AdminSubscriberController::class, 'index'])->name('subscribers.index');
    Route::delete('subscribers/{subscriber}', [AdminSubscriberController::class, 'destroy'])->name('subscribers.destroy');

    // Website Global Settings
    Route::get('settings', [AdminSettingController::class, 'edit'])->name('settings.edit');
    Route::put('settings', [AdminSettingController::class, 'update'])->name('settings.update');

    // Admin Accounts Management
    Route::post('admins/{admin}/force-logout', [AdminUserController::class, 'forceLogout'])->name('admins.force_logout');
    Route::resource('admins', AdminUserController::class);

    // Roles & Permissions Management
    Route::resource('roles', AdminRoleController::class);

    // Login Activity & Security Logs
    Route::get('login-activities', [AdminLoginActivityController::class, 'index'])->name('login_activities.index');
    Route::delete('login-activities/clear', [AdminLoginActivityController::class, 'clear'])->name('login_activities.clear');
    Route::delete('login-activities/{activity}', [AdminLoginActivityController::class, 'destroy'])->name('login_activities.destroy');
});
