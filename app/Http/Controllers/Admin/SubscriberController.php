<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscriber;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class SubscriberController extends Controller
{
    /**
     * Display a listing of newsletter subscribers.
     */
    public function index(): View
    {
        Gate::authorize('subscribers.view');

        $subscribers = Subscriber::latest('subscribed_at')->paginate(25);

        return view('admin.subscribers.index', compact('subscribers'));
    }

    /**
     * Remove the specified subscriber from storage.
     */
    public function destroy(Subscriber $subscriber): RedirectResponse
    {
        Gate::authorize('subscribers.delete');

        $subscriber->delete();

        return redirect()->route('admin.subscribers.index')
            ->with('success', 'সাবস্ক্রাইবার সফলভাবে মুছে ফেলা হয়েছে!');
    }
}
