<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LoginActivity;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class LoginActivityController extends Controller
{
    /**
     * Display a listing of login activities.
     */
    public function index(Request $request): View
    {
        Gate::authorize('login_activities.view');

        $query = LoginActivity::with('user')->latest('id');

        if ($request->filled('status')) {
            $query->where('status', $request->query('status'));
        }

        if ($request->filled('search')) {
            $search = trim((string) $request->query('search'));
            $query->where(function ($q) use ($search): void {
                $q->where('email', 'like', "%{$search}%")
                    ->orWhere('ip_address', 'like', "%{$search}%")
                    ->orWhere('device', 'like', "%{$search}%");
            });
        }

        $activities = $query->paginate(25)->withQueryString();

        $stats = [
            'total' => LoginActivity::count(),
            'successful' => LoginActivity::where('status', 'successful')->count(),
            'failed' => LoginActivity::where('status', 'failed')->count(),
            'locked' => LoginActivity::where('status', 'locked')->count(),
        ];

        return view('admin.login_activities.index', compact('activities', 'stats'));
    }

    /**
     * Delete a single login activity log.
     */
    public function destroy(LoginActivity $activity): RedirectResponse
    {
        Gate::authorize('login_activities.delete');

        $activity->delete();

        return redirect()->route('admin.login_activities.index')
            ->with('success', 'লগইন অ্যাক্টিভিটি রেকর্ড মুছে ফেলা হয়েছে!');
    }

    /**
     * Clear all login activities.
     */
    public function clear(): RedirectResponse
    {
        Gate::authorize('login_activities.delete');

        LoginActivity::truncate();

        return redirect()->route('admin.login_activities.index')
            ->with('success', 'সকল লগইন অ্যাক্টিভিটি হিস্টোরি মুছে ফেলা হয়েছে!');
    }
}
