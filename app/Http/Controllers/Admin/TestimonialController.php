<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class TestimonialController extends Controller
{
    /**
     * Display a listing of testimonials.
     */
    public function index(): View
    {
        Gate::authorize('testimonials.view');

        $testimonials = Testimonial::orderBy('order')->latest()->paginate(15);

        return view('admin.testimonials.index', compact('testimonials'));
    }

    /**
     * Show the form for creating a new testimonial.
     */
    public function create(): View
    {
        Gate::authorize('testimonials.create');

        return view('admin.testimonials.create');
    }

    /**
     * Store a newly created testimonial in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        Gate::authorize('testimonials.create');

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'designation' => ['nullable', 'string', 'max:255'],
            'comment' => ['required', 'string', 'max:2000'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['boolean'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,svg', 'max:2048'],
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['order'] = (int) ($validated['order'] ?? 0);

        if ($request->hasFile('image')) {
            $destDir = public_path('uploads/testimonials');
            if (! File::exists($destDir)) {
                File::makeDirectory($destDir, 0755, true);
            }
            $imageName = time().'_'.uniqid().'.'.$request->file('image')->getClientOriginalExtension();
            $request->file('image')->move($destDir, $imageName);
            $validated['image'] = 'uploads/testimonials/'.$imageName;
        }

        Testimonial::create($validated);

        return redirect()->route('admin.testimonials.index')
            ->with('success', 'প্রশংসাপত্র সফলভাবে যুক্ত হয়েছে!');
    }

    /**
     * Show the form for editing the specified testimonial.
     */
    public function edit(Testimonial $testimonial): View
    {
        Gate::authorize('testimonials.edit');

        return view('admin.testimonials.edit', compact('testimonial'));
    }

    /**
     * Update the specified testimonial in storage.
     */
    public function update(Request $request, Testimonial $testimonial): RedirectResponse
    {
        Gate::authorize('testimonials.edit');

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'designation' => ['nullable', 'string', 'max:255'],
            'comment' => ['required', 'string', 'max:2000'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['boolean'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,svg', 'max:2048'],
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['order'] = (int) ($validated['order'] ?? 0);

        if ($request->hasFile('image')) {
            $destDir = public_path('uploads/testimonials');
            if (! File::exists($destDir)) {
                File::makeDirectory($destDir, 0755, true);
            }
            if ($testimonial->image && ! str_starts_with($testimonial->image, 'assets/') && File::exists(public_path($testimonial->image))) {
                File::delete(public_path($testimonial->image));
            }
            $imageName = time().'_'.uniqid().'.'.$request->file('image')->getClientOriginalExtension();
            $request->file('image')->move($destDir, $imageName);
            $validated['image'] = 'uploads/testimonials/'.$imageName;
        }

        $testimonial->update($validated);

        return redirect()->route('admin.testimonials.index')
            ->with('success', 'প্রশংসাপত্র সফলভাবে আপডেট হয়েছে!');
    }

    /**
     * Remove the specified testimonial from storage.
     */
    public function destroy(Testimonial $testimonial): RedirectResponse
    {
        Gate::authorize('testimonials.delete');

        if ($testimonial->image && ! str_starts_with($testimonial->image, 'assets/') && File::exists(public_path($testimonial->image))) {
            File::delete(public_path($testimonial->image));
        }

        $testimonial->delete();

        return redirect()->route('admin.testimonials.index')
            ->with('success', 'প্রশংসাপত্র সফলভাবে মুছে ফেলা হয়েছে!');
    }
}
