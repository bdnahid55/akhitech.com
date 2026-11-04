@extends('admin.layouts.app')

@section('title', 'ব্লগ সম্পাদনা')
@section('page_title', 'ব্লগ পোস্ট সম্পাদনা')

@section('content')
    <div class="card card-outline card-info shadow-sm">
        <div class="card-header">
            <h3 class="card-title font-weight-bold">সম্পাদনা: {{ $post->title }}</h3>
            <div class="card-tools">
                <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left mr-1"></i> তালিকায় ফিরে যান
                </a>
            </div>
        </div>
        <form action="{{ route('admin.posts.update', $post) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8 form-group">
                        <label for="title">পোস্টের শিরোনাম <span class="text-danger">*</span></label>
                        <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $post->title) }}" required>
                        @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="author">লেখক</label>
                        <input type="text" name="author" id="author" class="form-control" value="{{ old('author', $post->author) }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="image">ফিচার্ড ছবি পরিবর্তন করুন</label>
                        @if ($post->image)
                            <div class="mb-2">
                                <img src="{{ asset($post->image) }}" alt="current image" class="img-thumbnail" style="height: 100px;">
                            </div>
                        @endif
                        <input type="file" name="image" id="image" class="form-control-file @error('image') is-invalid @enderror" accept="image/*">
                        <small class="text-muted">JPG, PNG, বা WebP (সর্বোচ্চ 2MB)</small>
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="published_at">প্রকাশের তারিখ</label>
                        <input type="datetime-local" name="published_at" id="published_at" class="form-control" value="{{ old('published_at', $post->published_at ? $post->published_at->format('Y-m-d\TH:i') : '') }}">
                    </div>
                </div>

                <div class="form-group">
                    <label for="excerpt">সংক্ষিপ্ত ভূমিকা (Excerpt)</label>
                    <textarea name="excerpt" id="excerpt" rows="3" class="form-control">{{ old('excerpt', $post->excerpt) }}</textarea>
                </div>

                <div class="form-group">
                    <label for="content">মূল বিষয়বস্তু <span class="text-danger">*</span></label>
                    <textarea name="content" id="content" class="form-control summernote" required>{{ old('content', $post->content) }}</textarea>
                    @error('content') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>

                <div class="form-check mb-3">
                    <input type="checkbox" name="is_published" value="1" class="form-check-input" id="is_published" {{ old('is_published', $post->is_published) ? 'checked' : '' }}>
                    <label class="form-check-label font-weight-bold" for="is_published">প্রকাশিত রাখুন</label>
                </div>
            </div>
            <div class="card-footer bg-light text-right">
                <button type="submit" class="btn btn-info">
                    <i class="fas fa-sync-alt mr-1"></i> আপডেট করুন
                </button>
            </div>
        </form>
    </div>
@endsection
