<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PackageController extends Controller
{
    /**
     * Display a listing of packages.
     */
    public function index(): View
    {
        $packages = Package::orderBy('order')->latest()->paginate(15);

        return view('admin.packages.index', compact('packages'));
    }

    /**
     * Show the form for creating a new package.
     */
    public function create(): View
    {
        return view('admin.packages.create');
    }

    /**
     * Store a newly created package in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:packages,slug'],
            'price' => ['required', 'string', 'max:50'],
            'currency' => ['nullable', 'string', 'max:10'],
            'period' => ['nullable', 'string', 'max:100'],
            'features_text' => ['required', 'string'],
            'button_text' => ['nullable', 'string', 'max:100'],
            'button_url' => ['nullable', 'string', 'max:500'],
            'is_featured' => ['boolean'],
            'is_active' => ['boolean'],
            'order' => ['nullable', 'integer', 'min:0'],
        ]);

        $validated['slug'] = ! empty($validated['slug'])
            ? Str::slug($validated['slug'])
            : Str::slug($validated['name']).'-'.rand(100, 999);

        $features = array_values(array_filter(
            array_map('trim', explode("\n", (string) $validated['features_text'])),
            fn (string $line): bool => $line !== ''
        ));

        $validated['features'] = $features;
        $validated['currency'] = $validated['currency'] ?: '৳';
        $validated['button_text'] = $validated['button_text'] ?: 'আমি নিতে চাই';
        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['order'] = (int) ($validated['order'] ?? 0);

        unset($validated['features_text']);

        Package::create($validated);

        return redirect()->route('admin.packages.index')
            ->with('success', 'প্যাকেজ সফলভাবে যুক্ত হয়েছে!');
    }

    /**
     * Show the form for editing the specified package.
     */
    public function edit(Package $package): View
    {
        return view('admin.packages.edit', compact('package'));
    }

    /**
     * Update the specified package in storage.
     */
    public function update(Request $request, Package $package): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:packages,slug,'.$package->id],
            'price' => ['required', 'string', 'max:50'],
            'currency' => ['nullable', 'string', 'max:10'],
            'period' => ['nullable', 'string', 'max:100'],
            'features_text' => ['required', 'string'],
            'button_text' => ['nullable', 'string', 'max:100'],
            'button_url' => ['nullable', 'string', 'max:500'],
            'is_featured' => ['boolean'],
            'is_active' => ['boolean'],
            'order' => ['nullable', 'integer', 'min:0'],
        ]);

        $validated['slug'] = ! empty($validated['slug'])
            ? Str::slug($validated['slug'])
            : $package->slug;

        $features = array_values(array_filter(
            array_map('trim', explode("\n", (string) $validated['features_text'])),
            fn (string $line): bool => $line !== ''
        ));

        $validated['features'] = $features;
        $validated['currency'] = $validated['currency'] ?: '৳';
        $validated['button_text'] = $validated['button_text'] ?: 'আমি নিতে চাই';
        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_active'] = $request->boolean('is_active');
        $validated['order'] = (int) ($validated['order'] ?? 0);

        unset($validated['features_text']);

        $package->update($validated);

        return redirect()->route('admin.packages.index')
            ->with('success', 'প্যাকেজ সফলভাবে আপডেট হয়েছে!');
    }

    /**
     * Remove the specified package from storage.
     */
    public function destroy(Package $package): RedirectResponse
    {
        $package->delete();

        return redirect()->route('admin.packages.index')
            ->with('success', 'প্যাকেজ সফলভাবে মুছে ফেলা হয়েছে!');
    }
}
