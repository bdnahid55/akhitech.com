<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class AchievementController extends Controller
{
    /**
     * Display a listing of achievements.
     */
    public function index(): View
    {
        Gate::authorize('achievements.view');

        $achievements = Achievement::orderBy('order')->latest()->paginate(15);

        return view('admin.achievements.index', compact('achievements'));
    }

    /**
     * Show the form for creating a new achievement.
     */
    public function create(): View
    {
        Gate::authorize('achievements.create');

        return view('admin.achievements.create');
    }

    /**
     * Store a newly created achievement in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        Gate::authorize('achievements.create');

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'count' => ['required', 'string', 'max:50'],
            'suffix' => ['nullable', 'string', 'max:20'],
            'icon' => ['nullable', 'string', 'max:100'],
            'order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['boolean'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,svg', 'max:2048'],
        ]);

        $validated['suffix'] = $validated['suffix'] ?? '+';
        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['order'] = (int) ($validated['order'] ?? 0);

        if ($request->hasFile('image')) {
            $destDir = public_path('uploads/achievements');
            if (! File::exists($destDir)) {
                File::makeDirectory($destDir, 0755, true);
            }
            $imageName = time().'_'.uniqid().'.'.$request->file('image')->getClientOriginalExtension();
            $request->file('image')->move($destDir, $imageName);
            $validated['image'] = 'uploads/achievements/'.$imageName;
        }

        Achievement::create($validated);

        return redirect()->route('admin.achievements.index')
            ->with('success', 'অর্জন সফলভাবে যুক্ত করা হয়েছে!');
    }

    /**
     * Show the form for editing the specified achievement.
     */
    public function edit(Achievement $achievement): View
    {
        Gate::authorize('achievements.edit');

        return view('admin.achievements.edit', compact('achievement'));
    }

    /**
     * Update the specified achievement in storage.
     */
    public function update(Request $request, Achievement $achievement): RedirectResponse
    {
        Gate::authorize('achievements.edit');

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'count' => ['required', 'string', 'max:50'],
            'suffix' => ['nullable', 'string', 'max:20'],
            'icon' => ['nullable', 'string', 'max:100'],
            'order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['boolean'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,svg', 'max:2048'],
        ]);

        $validated['suffix'] = $validated['suffix'] ?? '+';
        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['order'] = (int) ($validated['order'] ?? 0);

        if ($request->hasFile('image')) {
            $destDir = public_path('uploads/achievements');
            if (! File::exists($destDir)) {
                File::makeDirectory($destDir, 0755, true);
            }
            if ($achievement->image && ! str_starts_with($achievement->image, 'assets/') && File::exists(public_path($achievement->image))) {
                File::delete(public_path($achievement->image));
            }
            $imageName = time().'_'.uniqid().'.'.$request->file('image')->getClientOriginalExtension();
            $request->file('image')->move($destDir, $imageName);
            $validated['image'] = 'uploads/achievements/'.$imageName;
        }

        $achievement->update($validated);

        return redirect()->route('admin.achievements.index')
            ->with('success', 'অর্জন সফলভাবে আপডেট হয়েছে!');
    }

    /**
     * Remove the specified achievement from storage.
     */
    public function destroy(Achievement $achievement): RedirectResponse
    {
        Gate::authorize('achievements.delete');

        if ($achievement->image && ! str_starts_with($achievement->image, 'assets/') && File::exists(public_path($achievement->image))) {
            File::delete(public_path($achievement->image));
        }

        $achievement->delete();

        return redirect()->route('admin.achievements.index')
            ->with('success', 'অর্জন সফলভাবে মুছে ফেলা হয়েছে!');
    }
}
