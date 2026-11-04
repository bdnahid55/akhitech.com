@extends('admin.layouts.app')

@section('title', 'নতুন প্যাকেজ')
@section('page_title', 'নতুন প্যাকেজ যুক্ত করুন')

@section('content')
    <div class="card card-outline card-primary shadow-sm">
        <div class="card-header">
            <h3 class="card-title font-weight-bold">প্যাকেজের তথ্য</h3>
            <div class="card-tools">
                <a href="{{ route('admin.packages.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left mr-1"></i> তালিকায় ফিরে যান
                </a>
            </div>
        </div>
        <form action="{{ route('admin.packages.store') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="name">প্যাকেজের নাম <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="উদা: ই-কমার্স ওয়েবসাইট" required>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="slug">স্লাগ (ঐচ্ছিক)</label>
                        <input type="text" name="slug" id="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug') }}" placeholder="স্বয়ংক্রিয়ভাবে তৈরি হবে">
                        @error('slug') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3 form-group">
                        <label for="currency">কারেন্সি সিম্বল</label>
                        <input type="text" name="currency" id="currency" class="form-control @error('currency') is-invalid @enderror" value="{{ old('currency', '৳') }}">
                    </div>
                    <div class="col-md-5 form-group">
                        <label for="price">মূল্য <span class="text-danger">*</span></label>
                        <input type="text" name="price" id="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}" placeholder="উদা: 10000" required>
                        @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="period">ডেলিভারি সময়কাল বা সাবটাইটেল</label>
                        <input type="text" name="period" id="period" class="form-control @error('period') is-invalid @enderror" value="{{ old('period', '/৭ দিনের মধ্যে ডেলিভারি') }}" placeholder="উদা: /৭ দিনের মধ্যে ডেলিভারি">
                        @error('period') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="features_text">প্যাকেজের ফিচারসমূহ <span class="text-danger">*</span></label>
                    <textarea name="features_text" id="features_text" rows="7" class="form-control @error('features_text') is-invalid @enderror" placeholder="প্রতিটি লাইনে একটি করে ফিচার লিখুন..." required>{{ old('features_text') }}</textarea>
                    <small class="form-text text-muted">
                        <i class="fas fa-info-circle mr-1"></i> প্রতিটি লাইনে একটি করে ফিচার লিখুন। যদি কোনো ফিচার বাদ/অপ্রাপ্য হিসেবে লাল বা ক্রস দেখাতে চান, তাহলে লাইনের শুরুতে <code>x </code> বা <code>- </code> দিন।
                    </small>
                    @error('features_text') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="button_text">বাটনের লেখা</label>
                        <input type="text" name="button_text" id="button_text" class="form-control @error('button_text') is-invalid @enderror" value="{{ old('button_text', 'আমি নিতে চাই') }}">
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="button_url">কাস্টম বাটন লিংক (ঐচ্ছিক)</label>
                        <input type="text" name="button_url" id="button_url" class="form-control @error('button_url') is-invalid @enderror" value="{{ old('button_url') }}" placeholder="ফাঁকা রাখলে স্বয়ংক্রিয়ভাবে ফ্রি কোটেশন পেজে নিয়ে যাবে">
                        <small class="text-muted">হোয়াটসঅ্যাপ, মেসেঞ্জার অথবা নিজস্ব লিংক দিতে পারেন।</small>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 form-group">
                        <label for="order">ক্রমিক নম্বর</label>
                        <input type="number" name="order" id="order" class="form-control @error('order') is-invalid @enderror" value="{{ old('order', 0) }}">
                    </div>
                    <div class="col-md-4 form-group pt-4">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" name="is_featured" value="1" class="custom-control-input" id="is_featured" {{ old('is_featured') ? 'checked' : '' }}>
                            <label class="custom-control-label font-weight-bold" for="is_featured">ফিচার্ড / হাইলাইটেড প্যাকেজ (সবুজ ব্যাকগ্রাউন্ড)</label>
                        </div>
                    </div>
                    <div class="col-md-4 form-group pt-4">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" name="is_active" value="1" class="custom-control-input" id="is_active" {{ old('is_active', true) ? 'checked' : '' }}>
                            <label class="custom-control-label font-weight-bold" for="is_active">সক্রিয় স্ট্যাটাস</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-light">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save mr-1"></i> প্যাকেজ সংরক্ষণ করুন
                </button>
                <a href="{{ route('admin.packages.index') }}" class="btn btn-secondary">বাতিল</a>
            </div>
        </form>
    </div>
@endsection
