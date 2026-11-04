@extends('admin.layouts.app')

@section('title', 'পোর্টফোলিও সম্পাদনা')
@section('page_title', 'প্রজেক্ট সম্পাদনা')

@section('content')
    <div class="card card-outline card-info shadow-sm">
        <div class="card-header">
            <h3 class="card-title font-weight-bold">সম্পাদনা: {{ $portfolio->title }}</h3>
            <div class="card-tools">
                <a href="{{ route('admin.portfolios.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left mr-1"></i> তালিকায় ফিরে যান
                </a>
            </div>
        </div>
        <form action="{{ route('admin.portfolios.update', $portfolio) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="title">প্রজেক্টের শিরোনাম <span class="text-danger">*</span></label>
                        <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $portfolio->title) }}" required>
                        @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="category">ক্যাটাগরি <span class="text-danger">*</span></label>
                        <input type="text" name="category" id="category" class="form-control @error('category') is-invalid @enderror" value="{{ old('category', $portfolio->category) }}" required>
                        @error('category') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="client_name">ক্লায়েন্টের নাম</label>
                        <input type="text" name="client_name" id="client_name" class="form-control @error('client_name') is-invalid @enderror" value="{{ old('client_name', $portfolio->client_name) }}">
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="project_url">লাইভ ওয়েবসাইট লিংক</label>
                        <input type="url" name="project_url" id="project_url" class="form-control @error('project_url') is-invalid @enderror" value="{{ old('project_url', $portfolio->project_url) }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="start_date">শুরুর তারিখ</label>
                        <input type="text" name="start_date" id="start_date" class="form-control" value="{{ old('start_date', $portfolio->start_date) }}" placeholder="যেমন: 01/15/2025">
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="end_date">সাবমিট / শেষ করার তারিখ</label>
                        <input type="text" name="end_date" id="end_date" class="form-control" value="{{ old('end_date', $portfolio->end_date) }}" placeholder="যেমন: 02/10/2025">
                    </div>
                </div>

                <div class="form-group">
                    <label for="image">ছবি পরিবর্তন করুন (ঐচ্ছিক)</label>
                    @if ($portfolio->image)
                        <div class="mb-2">
                            <img src="{{ asset($portfolio->image) }}" alt="current image" class="img-thumbnail" style="height: 100px;">
                        </div>
                    @endif
                    <input type="file" name="image" id="image" class="form-control-file @error('image') is-invalid @enderror" accept="image/*">
                    <small class="text-muted">JPG, PNG, বা WebP (সর্বোচ্চ 2MB)</small>
                </div>

                <div class="form-group">
                    <label for="description">সংক্ষিপ্ত বিবরণ</label>
                    <textarea name="description" id="description" rows="4" class="form-control">{{ old('description', $portfolio->description) }}</textarea>
                </div>

                <div class="row">
                    <div class="col-md-6 form-check mb-3 pl-4">
                        <input type="checkbox" name="is_featured" value="1" class="form-check-input" id="is_featured" {{ old('is_featured', $portfolio->is_featured) ? 'checked' : '' }}>
                        <label class="form-check-label font-weight-bold" for="is_featured">হোমপেজে ফিচার্ড হিসেবে প্রদর্শন করুন</label>
                    </div>
                    <div class="col-md-6 form-check mb-3 pl-4">
                        <input type="checkbox" name="is_active" value="1" class="form-check-input" id="is_active" {{ old('is_active', $portfolio->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label font-weight-bold" for="is_active">প্রজেক্টটি সক্রিয় রাখুন</label>
                    </div>
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
