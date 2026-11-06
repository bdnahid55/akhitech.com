<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Services\FileUploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PageController extends Controller
{
    /**
     * Display a listing of custom pages.
     */
    public function index(): View
    {
        Gate::authorize('pages.view');

        $pages = Page::with('parent')
            ->orderBy('order')
            ->orderBy('title')
            ->paginate(15);

        return view('admin.pages.index', compact('pages'));
    }

    /**
     * Show the form for creating a new page.
     */
    public function create(): View
    {
        Gate::authorize('pages.create');

        $parentPages = Page::whereNull('header_parent_id')->orderBy('title')->get();

        return view('admin.pages.create', compact('parentPages'));
    }

    /**
     * Store a newly created page in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        Gate::authorize('pages.create');

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:pages,slug'],
            'content' => ['required', 'string'],
            'header_parent_id' => ['nullable', 'exists:pages,id'],
            'show_in_header' => ['boolean'],
            'show_in_footer' => ['boolean'],
            'footer_column' => ['nullable', 'in:quick_links,legal'],
            'order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['boolean'],
            'banner_image' => FileUploadService::imageRules(),
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'meta_keywords' => ['nullable', 'string', 'max:255'],
            'canonical_url' => ['nullable', 'url', 'max:255'],
            'og_image' => FileUploadService::imageRules(),
        ]);

        $validated['slug'] = ! empty($validated['slug'])
            ? Str::slug($validated['slug'])
            : Str::slug($validated['title']).'-'.rand(100, 999);

        if ($request->hasFile('banner_image')) {
            $validated['banner_image'] = FileUploadService::storeImage($request->file('banner_image'), 'pages', 'banner_image');
        }

        if ($request->hasFile('og_image')) {
            $validated['og_image'] = FileUploadService::storeImage($request->file('og_image'), 'pages', 'og_image');
        }

        $validated['show_in_header'] = $request->boolean('show_in_header');
        $validated['show_in_footer'] = $request->boolean('show_in_footer');
        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['order'] = (int) ($validated['order'] ?? 0);

        Page::create($validated);

        return redirect()->route('admin.pages.index')
            ->with('success', 'নতুন পেজ সফলভাবে তৈরি হয়েছে!');
    }

    /**
     * Show the form for editing the specified page.
     */
    public function edit(Page $page): View
    {
        Gate::authorize('pages.edit');

        $parentPages = Page::whereNull('header_parent_id')
            ->where('id', '!=', $page->id)
            ->orderBy('title')
            ->get();

        return view('admin.pages.edit', compact('page', 'parentPages'));
    }

    /**
     * Update the specified page in storage.
     */
    public function update(Request $request, Page $page): RedirectResponse
    {
        Gate::authorize('pages.edit');

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', Rule::unique('pages')->ignore($page->id)],
            'content' => ['required', 'string'],
            'header_parent_id' => ['nullable', 'exists:pages,id', Rule::notIn([$page->id])],
            'show_in_header' => ['boolean'],
            'show_in_footer' => ['boolean'],
            'footer_column' => ['nullable', 'in:quick_links,legal'],
            'order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['boolean'],
            'banner_image' => FileUploadService::imageRules(),
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'meta_keywords' => ['nullable', 'string', 'max:255'],
            'canonical_url' => ['nullable', 'url', 'max:255'],
            'og_image' => FileUploadService::imageRules(),
        ]);

        $validated['slug'] = Str::slug($validated['slug']);

        if ($request->hasFile('banner_image')) {
            FileUploadService::deleteOldImage($page->banner_image);
            $validated['banner_image'] = FileUploadService::storeImage($request->file('banner_image'), 'pages', 'banner_image');
        }

        if ($request->hasFile('og_image')) {
            FileUploadService::deleteOldImage($page->og_image);
            $validated['og_image'] = FileUploadService::storeImage($request->file('og_image'), 'pages', 'og_image');
        }

        $validated['show_in_header'] = $request->boolean('show_in_header');
        $validated['show_in_footer'] = $request->boolean('show_in_footer');
        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['order'] = (int) ($validated['order'] ?? 0);

        $page->update($validated);

        return redirect()->route('admin.pages.index')
            ->with('success', 'পেজ সফলভাবে আপডেট হয়েছে!');
    }

    /**
     * Remove the specified page from storage.
     */
    public function destroy(Page $page): RedirectResponse
    {
        Gate::authorize('pages.delete');

        FileUploadService::deleteOldImage($page->banner_image);
        FileUploadService::deleteOldImage($page->og_image);

        $page->delete();

        return redirect()->route('admin.pages.index')
            ->with('success', 'পেজ সফলভাবে মুছে ফেলা হয়েছে!');
    }
}
