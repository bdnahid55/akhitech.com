@extends('admin.layouts.app')

@section('title', 'নতুন পেজ তৈরি')
@section('page_title', 'নতুন কাস্টম পেজ তৈরি করুন')

@section('content')
    <form action="{{ route('admin.pages.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <!-- Left Column: Content & SEO -->
            <div class="col-lg-8">
                <!-- Page Content Card -->
                <div class="card card-outline card-primary shadow-sm mb-4">
                    <div class="card-header">
                        <h3 class="card-title font-weight-bold"><i class="fas fa-file-alt mr-1"></i> পেজের মূল বিষয়বস্তু</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="title">পেজের শিরোনাম <span class="text-danger">*</span></label>
                            <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" placeholder="যেমন: আমাদের টিম / ক্যারিয়ার" required>
                            @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group">
                            <label for="slug">কাস্টম স্লাগ (URL Slug)</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">{{ url('/page') }}/</span>
                                </div>
                                <input type="text" name="slug" id="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug') }}" placeholder="ফাঁকা রাখলে স্বয়ংক্রিয়ভাবে তৈরি হবে">
                            </div>
                            @error('slug') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group">
                            <label for="banner_image">ব্যানার ছবি (ঐচ্ছিক)</label>
                            <input type="file" name="banner_image" id="banner_image" class="form-control-file @error('banner_image') is-invalid @enderror" accept="image/*">
                            <small class="text-muted">JPG, PNG, WebP (সর্বোচ্চ 2MB)</small>
                            @error('banner_image') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group">
                            <label for="content">পেজের কনটেন্ট / বর্ণনা <span class="text-danger">*</span></label>
                            <textarea name="content" id="content" class="form-control summernote" rows="12" required>{{ old('content') }}</textarea>
                            @error('content') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>

                <!-- SEO Optimization Card -->
                <div class="card card-outline card-success shadow-sm mb-4">
                    <div class="card-header">
                        <h3 class="card-title font-weight-bold"><i class="fas fa-search mr-1"></i> সার্চ ইঞ্জিন অপটিমাইজেশন (SEO)</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="meta_title">এসইও মেটা টাইটেল (Meta Title)</label>
                            <input type="text" name="meta_title" id="meta_title" class="form-control" value="{{ old('meta_title') }}" placeholder="ফাঁকা রাখলে পেজের শিরোনাম ব্যবহৃত হবে">
                            <small class="text-muted">গুগল সার্চ ফলাফলের জন্য সর্বোচ্চ ৬০-৭০ অক্ষর আদর্শ।</small>
                        </div>

                        <div class="form-group">
                            <label for="meta_description">মেটা ডেসক্রিপশন (Meta Description)</label>
                            <textarea name="meta_description" id="meta_description" rows="3" class="form-control" placeholder="এই পেজ সম্পর্কে সংক্ষিপ্ত সারসংক্ষেপ">{{ old('meta_description') }}</textarea>
                            <small class="text-muted">আদর্শ দৈর্ঘ্য ১২০-১৬০ অক্ষর।</small>
                        </div>

                        <div class="form-group">
                            <label for="meta_keywords">মেটা কি-ওয়ার্ডস (Keywords)</label>
                            <input type="text" name="meta_keywords" id="meta_keywords" class="form-control" value="{{ old('meta_keywords') }}" placeholder="কমা দিয়ে আলাদা করুন, যেমন: সফটওয়্যার, ওয়েব ডেভেলপমেন্ট, Akhitech">
                        </div>

                        <div class="form-group">
                            <label for="canonical_url">ক্যানোনিকাল URL (Canonical URL)</label>
                            <input type="url" name="canonical_url" id="canonical_url" class="form-control" value="{{ old('canonical_url') }}" placeholder="https://akhitech.com/page/...">
                            <small class="text-muted">ডুপ্লিকেট কনটেন্ট এড়াতে ক্যানোনিকাল লিঙ্ক দিতে পারেন।</small>
                        </div>

                        <div class="form-group">
                            <label for="og_image">সোশ্যাল শেয়ার ছবি (OpenGraph / OG Image)</label>
                            <input type="file" name="og_image" id="og_image" class="form-control-file" accept="image/*">
                            <small class="text-muted">ফেসবুক, টুইটার ও লিংকডইন শেয়ারিংয়ের জন্য প্রস্তাবিত সাইজ 1200x630px।</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Navigation & Settings -->
            <div class="col-lg-4">
                <!-- Navigation Settings Card -->
                <div class="card card-outline card-info shadow-sm mb-4">
                    <div class="card-header">
                        <h3 class="card-title font-weight-bold"><i class="fas fa-bars mr-1"></i> মেনু প্লেসমেন্ট সেটিংস</h3>
                    </div>
                    <div class="card-body">
                        <!-- Header Menu Placement -->
                        <div class="custom-control custom-switch mb-3">
                            <input type="checkbox" name="show_in_header" value="1" class="custom-control-input" id="show_in_header" {{ old('show_in_header', true) ? 'checked' : '' }}>
                            <label class="custom-control-label font-weight-bold" for="show_in_header">হেডার নেভিগেশন মেনুতে দেখান</label>
                        </div>

                        <!-- Dropdown Menu Parent -->
                        <div class="form-group">
                            <label for="header_parent_id">ড্রপডাউন মেনু প্যারেন্ট (Parent Page)</label>
                            <select name="header_parent_id" id="header_parent_id" class="form-control">
                                <option value="">-- শীর্ষ স্তরের মেনু (কোনো ড্রপডাউন নয়) --</option>
                                @foreach($parentPages as $parent)
                                    <option value="{{ $parent->id }}" {{ old('header_parent_id') == $parent->id ? 'selected' : '' }}>
                                        ↳ {{ $parent->title }} এর সাব-মেনু (Dropdown)
                                    </option>
                                @endforeach
                            </select>
                            <small class="text-muted">কোনো প্যারেন্ট সিলেক্ট করলে এটি তার আন্ডারে ড্রপডাউন মেনু হিসেবে প্রদর্শিত হবে।</small>
                        </div>

                        <hr>

                        <!-- Footer Menu Placement -->
                        <div class="custom-control custom-switch mb-3">
                            <input type="checkbox" name="show_in_footer" value="1" class="custom-control-input" id="show_in_footer" {{ old('show_in_footer') ? 'checked' : '' }}>
                            <label class="custom-control-label font-weight-bold" for="show_in_footer">ফুটার সেকশনে দেখান</label>
                        </div>

                        <div class="form-group">
                            <label for="footer_column">ফুটার কলাম নির্বাচন</label>
                            <select name="footer_column" id="footer_column" class="form-control">
                                <option value="quick_links" {{ old('footer_column', 'quick_links') === 'quick_links' ? 'selected' : '' }}>দ্রুত লিংক (Quick Links)</option>
                                <option value="legal" {{ old('footer_column') === 'legal' ? 'selected' : '' }}>আইনি নীতিমালা (Legal Policies)</option>
                            </select>
                        </div>

                        <hr>

                        <!-- Display Order -->
                        <div class="form-group">
                            <label for="order">মেনুতে প্রদর্শনের ক্রম (Order)</label>
                            <input type="number" name="order" id="order" class="form-control" value="{{ old('order', 0) }}" min="0">
                            <small class="text-muted">কম সংখ্যা আগে প্রদর্শিত হবে (যেমন: 0, 1, 2...)।</small>
                        </div>

                        <!-- Active Status -->
                        <div class="custom-control custom-switch mb-2">
                            <input type="checkbox" name="is_active" value="1" class="custom-control-input" id="is_active" {{ old('is_active', true) ? 'checked' : '' }}>
                            <label class="custom-control-label font-weight-bold" for="is_active">পেজটি সক্রিয় (Active) রাখুন</label>
                        </div>
                    </div>
                </div>

                <!-- Action Button Card -->
                <div class="card shadow-sm">
                    <div class="card-body">
                        <button type="submit" class="btn btn-primary btn-block font-weight-bold mb-2">
                            <i class="fas fa-save mr-1"></i> পেজটি সংরক্ষণ করুন
                        </button>
                        <a href="{{ route('admin.pages.index') }}" class="btn btn-secondary btn-block">
                            বাতিল করুন
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
