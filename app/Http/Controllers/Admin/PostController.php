<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PostController extends Controller
{
    /**
     * Display a listing of blog posts.
     */
    public function index(): View
    {
        Gate::authorize('posts.view');

        $posts = Post::latest('published_at')->paginate(15);

        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new post.
     */
    public function create(): View
    {
        Gate::authorize('posts.create');

        return view('admin.posts.create');
    }

    /**
     * Store a newly created post in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        Gate::authorize('posts.create');

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:posts,slug'],
            'excerpt' => ['nullable', 'string', 'max:1000'],
            'content' => ['required', 'string'],
            'author' => ['nullable', 'string', 'max:100'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'published_at' => ['nullable', 'date'],
            'is_published' => ['boolean'],
        ]);

        $validated['slug'] = ! empty($validated['slug'])
            ? Str::slug($validated['slug'])
            : Str::slug($validated['title']).'-'.rand(100, 999);

        if ($request->hasFile('image')) {
            $imageName = time().'_'.uniqid().'.'.$request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('uploads/posts'), $imageName);
            $validated['image'] = 'uploads/posts/'.$imageName;
        }

        $validated['author'] = $validated['author'] ?? 'এডমিন';
        $validated['published_at'] = $validated['published_at'] ?? now();
        $validated['is_published'] = $request->boolean('is_published', true);

        Post::create($validated);

        return redirect()->route('admin.posts.index')
            ->with('success', 'ব্লগ পোস্ট সফলভাবে তৈরি হয়েছে!');
    }

    /**
     * Show the form for editing the specified post.
     */
    public function edit(Post $post): View
    {
        Gate::authorize('posts.edit');

        return view('admin.posts.edit', compact('post'));
    }

    /**
     * Update the specified post in storage.
     */
    public function update(Request $request, Post $post): RedirectResponse
    {
        Gate::authorize('posts.edit');

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:posts,slug,'.$post->id],
            'excerpt' => ['nullable', 'string', 'max:1000'],
            'content' => ['required', 'string'],
            'author' => ['nullable', 'string', 'max:100'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'published_at' => ['nullable', 'date'],
            'is_published' => ['boolean'],
        ]);

        $validated['slug'] = ! empty($validated['slug'])
            ? Str::slug($validated['slug'])
            : $post->slug;

        if ($request->hasFile('image')) {
            $imageName = time().'_'.uniqid().'.'.$request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('uploads/posts'), $imageName);
            $validated['image'] = 'uploads/posts/'.$imageName;
        }

        $validated['is_published'] = $request->boolean('is_published');

        $post->update($validated);

        return redirect()->route('admin.posts.index')
            ->with('success', 'ব্লগ পোস্ট সফলভাবে আপডেট হয়েছে!');
    }

    /**
     * Remove the specified post from storage.
     */
    public function destroy(Post $post): RedirectResponse
    {
        Gate::authorize('posts.delete');

        $post->delete();

        return redirect()->route('admin.posts.index')
            ->with('success', 'ব্লগ পোস্ট মুছে ফেলা হয়েছে!');
    }
}
