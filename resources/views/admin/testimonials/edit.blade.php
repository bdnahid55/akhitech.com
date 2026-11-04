@extends('admin.layouts.app')

@section('title', 'প্রশংসাপত্র সম্পাদনা')
@section('page_title', 'প্রশংসাপত্র সম্পাদনা')

@section('content')
    <div class="card card-outline card-primary shadow-sm">
        <div class="card-header">
            <h3 class="card-title font-weight-bold">প্রশংসাপত্রের তথ্য সম্পাদনা করুন</h3>
            <div class="card-tools">
                <a href="{{ route('admin.testimonials.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left mr-1"></i> ফিরে যান
                </a>
            </div>
        </div>

        <form action="{{ route('admin.testimonials.update', $testimonial) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="name">ক্লায়েন্টের নাম <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $testimonial->name) }}" required>
                        @error('name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="designation">পদবী / কোম্পানি</label>
                        <input type="text" name="designation" id="designation" class="form-control @error('designation') is-invalid @enderror" value="{{ old('designation', $testimonial->designation) }}">
                        @error('designation')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="comment">ক্লায়েন্টের মন্তব্য / রিভিউ <span class="text-danger">*</span></label>
                    <textarea name="comment" id="comment" rows="4" class="form-control @error('comment') is-invalid @enderror" required>{{ old('comment', $testimonial->comment) }}</textarea>
                    @error('comment')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-4 form-group">
                        <label for="rating">রেটিং (স্টার) <span class="text-danger">*</span></label>
                        <select name="rating" id="rating" class="form-control @error('rating') is-invalid @enderror" required>
                            <option value="5" {{ old('rating', $testimonial->rating) == 5 ? 'selected' : '' }}>⭐⭐⭐⭐⭐ (৫ স্টার)</option>
                            <option value="4" {{ old('rating', $testimonial->rating) == 4 ? 'selected' : '' }}>⭐⭐⭐⭐ (৪ স্টার)</option>
                            <option value="3" {{ old('rating', $testimonial->rating) == 3 ? 'selected' : '' }}>⭐⭐⭐ (৩ স্টার)</option>
                            <option value="2" {{ old('rating', $testimonial->rating) == 2 ? 'selected' : '' }}>⭐⭐ (২ স্টার)</option>
                            <option value="1" {{ old('rating', $testimonial->rating) == 1 ? 'selected' : '' }}>⭐ (১ স্টার)</option>
                        </select>
                        @error('rating')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-4 form-group">
                        <label for="order">প্রদর্শনের ক্রম (Order)</label>
                        <input type="number" name="order" id="order" class="form-control @error('order') is-invalid @enderror" value="{{ old('order', $testimonial->order) }}" min="0">
                        @error('order')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-4 form-group">
                        <label for="image">ক্লায়েন্টের ছবি</label>
                        @if ($testimonial->image)
                            <div class="mb-2">
                                <img src="{{ asset($testimonial->image) }}" alt="{{ $testimonial->name }}" class="rounded-circle border" style="width: 50px; height: 50px; object-fit: cover;">
                            </div>
                        @endif
                        <input type="file" name="image" id="image" class="form-control-file @error('image') is-invalid @enderror" accept="image/*">
                        <small class="form-text text-muted">পরিবর্তন করতে চাইলে নতুন ছবি আপলোড করুন</small>
                        @error('image')
                            <span class="invalid-feedback d-block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-group mb-0">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" name="is_active" class="custom-control-input" id="is_active" value="1" {{ old('is_active', $testimonial->is_active) ? 'checked' : '' }}>
                        <label class="custom-control-label" for="is_active">ওয়েবসাইটে সক্রিয় থাকবে (Active)</label>
                    </div>
                </div>
            </div>

            <div class="card-footer text-right">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save mr-1"></i> আপডেট সংরক্ষণ করুন
                </button>
            </div>
        </form>
    </div>
@endsection
