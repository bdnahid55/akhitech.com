<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InquiryController extends Controller
{
    /**
     * Display a listing of client inquiries and quote requests.
     */
    public function index(Request $request): View
    {
        $type = $request->query('type');

        $query = Inquiry::query()->latest();

        if (in_array($type, ['contact', 'quote'], true)) {
            $query->where('type', $type);
        }

        $inquiries = $query->paginate(20);

        return view('admin.inquiries.index', compact('inquiries', 'type'));
    }

    /**
     * Display the specified inquiry and mark it as read.
     */
    public function show(Inquiry $inquiry): View
    {
        if (! $inquiry->is_read) {
            $inquiry->update(['is_read' => true]);
        }

        return view('admin.inquiries.show', compact('inquiry'));
    }

    /**
     * Remove the specified inquiry from storage.
     */
    public function destroy(Inquiry $inquiry): RedirectResponse
    {
        $inquiry->delete();

        return redirect()->route('admin.inquiries.index')
            ->with('success', 'বার্তাটি মুছে ফেলা হয়েছে!');
    }
}
