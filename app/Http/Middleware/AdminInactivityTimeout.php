<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminInactivityTimeout
{
    /**
     * Handle an incoming request and check for admin inactivity timeout.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $lastActivity = session('admin_last_activity_time');
            $timeoutSeconds = (int) config('auth.admin_idle_timeout', 900);

            if ($lastActivity !== null && (time() - (int) $lastActivity) > $timeoutSeconds) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                $minutes = (int) round($timeoutSeconds / 60);

                return redirect()->route('admin.login')
                    ->with('error', "অলসতার কারণে ({$minutes} মিনিট কোনো কার্যক্রম না থাকায়) আপনার সেশনটি স্বয়ংক্রিয়ভাবে বন্ধ করা হয়েছে। অনুগ্রহ করে পুনরায় লগইন করুন।");
            }

            session(['admin_last_activity_time' => time()]);
        }

        return $next($request);
    }
}
