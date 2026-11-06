<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LoginActivity;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AuthController extends Controller
{
    /**
     * Maximum allowed failed attempts before throttling.
     */
    protected const int MAX_ATTEMPTS = 5;

    /**
     * Lockout decay duration in seconds.
     */
    protected const int DECAY_SECONDS = 60;

    /**
     * Display the admin login form.
     */
    public function showLoginForm(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.auth.login');
    }

    /**
     * Handle admin login request with rate limiting & brute-force protection.
     */
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ], [
            'email.required' => 'ইমেইল এড্রেস লিখুন।',
            'email.email' => 'সঠিক ইমেইল ফরম্যাট দিন।',
            'password.required' => 'পাসওয়ার্ড লিখুন।',
        ]);

        $email = strtolower(trim((string) $credentials['email']));
        $throttleKey = Str::transliterate($email.'|'.$request->ip());

        // 1. Check Rate Limiting / Brute-force lockout
        if (RateLimiter::tooManyAttempts($throttleKey, self::MAX_ATTEMPTS)) {
            $seconds = RateLimiter::availableIn($throttleKey);

            LoginActivity::create([
                'user_id' => User::where('email', $email)->value('id'),
                'email' => $email,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'device' => $this->parseDevice($request->userAgent()),
                'status' => 'locked',
            ]);

            return back()->withInput($request->only('email'))
                ->with('error', "অতিরিক্ত ব্যর্থ লগইন চেষ্টার কারণে আপনার অ্যাকাউন্ট সাময়িকভাবে লক করা হয়েছে। অনুগ্রহ করে {$seconds} সেকেন্ড পর পুনরায় চেষ্টা করুন।");
        }

        $remember = $request->boolean('remember');

        // 2. Attempt Authentication
        if (Auth::attempt(['email' => $email, 'password' => $credentials['password']], $remember)) {
            RateLimiter::clear($throttleKey);

            $request->session()->regenerate();

            /** @var User|null $user */
            $user = Auth::user();

            LoginActivity::create([
                'user_id' => $user?->id,
                'email' => $email,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'device' => $this->parseDevice($request->userAgent()),
                'status' => 'successful',
            ]);

            return redirect()->intended(route('admin.dashboard'))
                ->with('success', 'সফলভাবে লগইন হয়েছে!');
        }

        // 3. Failed attempt: Increment Rate Limiter and record activity
        RateLimiter::hit($throttleKey, self::DECAY_SECONDS);

        LoginActivity::create([
            'user_id' => User::where('email', $email)->value('id'),
            'email' => $email,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'device' => $this->parseDevice($request->userAgent()),
            'status' => 'failed',
        ]);

        $remaining = RateLimiter::remaining($throttleKey, self::MAX_ATTEMPTS);
        $errorMessage = $remaining > 0
            ? "প্রদত্ত ইমেইল বা পাসওয়ার্ড সঠিক নয়। আর {$remaining} বার চেষ্টা করতে পারবেন।"
            : 'প্রদত্ত ইমেইল বা পাসওয়ার্ড সঠিক নয়। অতিরিক্ত চেষ্টার কারণে অ্যাকাউন্ট সাময়িকভাবে লক করা হয়েছে।';

        return back()->withInput($request->only('email'))
            ->with('error', $errorMessage);
    }

    /**
     * Log the admin out of the application.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')
            ->with('success', 'সফলভাবে লগআউট করা হয়েছে।');
    }

    /**
     * Helper to parse browser and platform from user agent.
     */
    protected function parseDevice(?string $userAgent): string
    {
        if (! $userAgent) {
            return 'Unknown Device';
        }

        $browser = 'Browser';
        if (str_contains($userAgent, 'Edg')) {
            $browser = 'Edge';
        } elseif (str_contains($userAgent, 'Chrome')) {
            $browser = 'Chrome';
        } elseif (str_contains($userAgent, 'Firefox')) {
            $browser = 'Firefox';
        } elseif (str_contains($userAgent, 'Safari')) {
            $browser = 'Safari';
        } elseif (str_contains($userAgent, 'Opera') || str_contains($userAgent, 'OPR')) {
            $browser = 'Opera';
        }

        $platform = 'Desktop';
        if (str_contains($userAgent, 'Mobile') || str_contains($userAgent, 'Android') || str_contains($userAgent, 'iPhone')) {
            $platform = 'Mobile';
        } elseif (str_contains($userAgent, 'iPad') || str_contains($userAgent, 'Tablet')) {
            $platform = 'Tablet';
        } elseif (str_contains($userAgent, 'Windows')) {
            $platform = 'Windows';
        } elseif (str_contains($userAgent, 'Macintosh') || str_contains($userAgent, 'Mac OS')) {
            $platform = 'macOS';
        } elseif (str_contains($userAgent, 'Linux')) {
            $platform = 'Linux';
        }

        return "{$browser} ({$platform})";
    }
}
