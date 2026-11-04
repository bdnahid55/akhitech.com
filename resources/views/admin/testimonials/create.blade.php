@extends('admin.layouts.app')

@section('title', 'নতুন প্রশংসাপত্র যোগ করুন')
@section('page_title', 'নতুন প্রশংসাপত্র')

@section('content')
    <div class="card card-outline card-primary shadow-sm">
        <div class="card-header">
            <h3 class="card-title font-weight-bold">প্রশংসাপত্রের তথ্য দিন</h3>
            <div class="card-tools">
                <a href="{{ route('admin.testimonials.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left mr-1"></i> ফিরে যান
                </a>
            </div>
        </div>

        <form action="{{ route('admin.testimonials.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="name">ক্লায়েন্টের নাম <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required placeholder="উদাঃ ফাতেমা আক্তার">
                        @error('name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="designation">পদবী / কোম্পানি</label>
                        <input type="text" name="designation" id="designation" class="form-control @error('designation') is-invalid @enderror" value="{{ old('designation') }}" placeholder="উদাঃ উদ্যোক্তা / সিইও">
                        @error('designation')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="comment">ক্লায়েন্টের মন্তব্য / রিভিউ <span class="text-danger">*</span></label>
                    <textarea name="comment" id="comment" rows="4" class="form-control @error('comment') is-invalid @enderror" required placeholder="ক্লায়েন্টের বিস্তারিত রিভিউ লিখুন...">{{ old('comment') }}</textarea>
                    @error('comment')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-4 form-group">
                        <label for="rating">রেটিং (স্টার) <span class="text-danger">*</span></label>
                        <select name="rating" id="rating" class="form-control @error('rating') is-invalid @enderror" required>
                            <option value="5" {{ old('rating', 5) == 5 ? 'selected' : '' }}>⭐⭐⭐⭐⭐ (৫ স্টার)</option>
                            <option value="4" {{ old('rating') == 4 ? 'selected' : '' }}>⭐⭐⭐⭐ (৪ স্টার)</option>
                            <option value="3" {{ old('rating') == 3 ? 'selected' : '' }}>⭐⭐⭐ (৩ স্টার)</option>
                            <option value="2" {{ old('rating') == 2 ? 'selected' : '' }}>⭐⭐ (২ স্টার)</option>
                            <option value="1" {{ old('rating') == 1 ? 'selected' : '' }}>⭐ (১ স্টার)</option>
                        </select>
                        @error('rating')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-4 form-group">
                        <label for="order">প্রদর্শনের ক্রম (Order)</label>
                        <input type="number" name="order" id="order" class="form-control @error('order') is-invalid @enderror" value="{{ old('order', 0) }}" min="0">
                        @error('order')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-4 form-group">
                        <label for="image">ক্লায়েন্টের ছবি</label>
                        <input type="file" name="image" id="image" class="form-control-file @error('image') is-invalid @enderror" accept="image/*">
                        <small class="form-text text-muted">সর্বোচ্চ ২MB (JPG, PNG, WebP)</small>
                        @error('image')
                            <span class="invalid-feedback d-block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-group mb-0">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" name="is_active" class="custom-control-input" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                        <label class="custom-control-label" for="is_active">ওয়েবসাইটে সক্রিয় থাকবে (Active)</label>
                    </div>
                </div>
            </div>

            <div class="card-footer text-right">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save mr-1"></i> সংরক্ষণ করুন
                </button>
            </div>
        </form>
    </div>
@endsection
