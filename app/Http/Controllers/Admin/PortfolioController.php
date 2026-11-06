<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use App\Services\FileUploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PortfolioController extends Controller
{
    /**
     * Display a listing of portfolio projects.
     */
    public function index(): View
    {
        Gate::authorize('portfolios.view');

        $portfolios = Portfolio::latest()->paginate(15);

        return view('admin.portfolios.index', compact('portfolios'));
    }

    /**
     * Show the form for creating a new portfolio.
     */
    public function create(): View
    {
        Gate::authorize('portfolios.create');

        return view('admin.portfolios.create');
    }

    /**
     * Store a newly created portfolio in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        Gate::authorize('portfolios.create');

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:portfolios,slug'],
            'category' => ['required', 'string', 'max:150'],
            'client_name' => ['nullable', 'string', 'max:255'],
            'start_date' => ['nullable', 'string', 'max:100'],
            'end_date' => ['nullable', 'string', 'max:100'],
            'project_url' => ['nullable', 'url', 'max:255'],
            'description' => ['nullable', 'string'],
            'image' => FileUploadService::imageRules(),
            'is_featured' => ['boolean'],
            'is_active' => ['boolean'],
        ]);

        $validated['slug'] = ! empty($validated['slug'])
            ? Str::slug($validated['slug'])
            : Str::slug($validated['title']).'-'.rand(100, 999);

        if ($request->hasFile('image')) {
            $validated['image'] = FileUploadService::storeImage($request->file('image'), 'portfolios');
        }

        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_active'] = $request->boolean('is_active', true);

        Portfolio::create($validated);

        return redirect()->route('admin.portfolios.index')
            ->with('success', 'পোর্টফোলিও প্রজেক্ট সফলভাবে যুক্ত হয়েছে!');
    }

    /**
     * Show the form for editing the specified portfolio.
     */
    public function edit(Portfolio $portfolio): View
    {
        Gate::authorize('portfolios.edit');

        return view('admin.portfolios.edit', compact('portfolio'));
    }

    /**
     * Update the specified portfolio in storage.
     */
    public function update(Request $request, Portfolio $portfolio): RedirectResponse
    {
        Gate::authorize('portfolios.edit');

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:portfolios,slug,'.$portfolio->id],
            'category' => ['required', 'string', 'max:150'],
            'client_name' => ['nullable', 'string', 'max:255'],
            'start_date' => ['nullable', 'string', 'max:100'],
            'end_date' => ['nullable', 'string', 'max:100'],
            'project_url' => ['nullable', 'url', 'max:255'],
            'description' => ['nullable', 'string'],
            'image' => FileUploadService::imageRules(),
            'is_featured' => ['boolean'],
            'is_active' => ['boolean'],
        ]);

        $validated['slug'] = ! empty($validated['slug'])
            ? Str::slug($validated['slug'])
            : $portfolio->slug;

        if ($request->hasFile('image')) {
            FileUploadService::deleteOldImage($portfolio->image);
            $validated['image'] = FileUploadService::storeImage($request->file('image'), 'portfolios');
        }

        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_active'] = $request->boolean('is_active');

        $portfolio->update($validated);

        return redirect()->route('admin.portfolios.index')
            ->with('success', 'পোর্টফোলিও সফলভাবে আপডেট হয়েছে!');
    }

    /**
     * Remove the specified portfolio from storage.
     */
    public function destroy(Portfolio $portfolio): RedirectResponse
    {
        Gate::authorize('portfolios.delete');

        FileUploadService::deleteOldImage($portfolio->image);

        $portfolio->delete();

        return redirect()->route('admin.portfolios.index')
            ->with('success', 'পোর্টফোলিও প্রজেক্ট মুছে ফেলা হয়েছে!');
    }
}
