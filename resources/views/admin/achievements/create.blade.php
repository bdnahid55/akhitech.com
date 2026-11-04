@extends('admin.layouts.app')

@section('title', 'নতুন অর্জন যোগ করুন')
@section('page_title', 'নতুন অর্জন ও কাউন্টার')

@section('content')
    <div class="card card-outline card-primary shadow-sm">
        <div class="card-header">
            <h3 class="card-title font-weight-bold">অর্জনের তথ্য দিন</h3>
            <div class="card-tools">
                <a href="{{ route('admin.achievements.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left mr-1"></i> ফিরে যান
                </a>
            </div>
        </div>

        <form action="{{ route('admin.achievements.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="title">অর্জনের শিরোনাম <span class="text-danger">*</span></label>
                        <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required placeholder="উদাঃ কমপ্লিট প্রোজেক্ট">
                        @error('title')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-3 form-group">
                        <label for="count">কাউন্টের সংখ্যা <span class="text-danger">*</span></label>
                        <input type="text" name="count" id="count" class="form-control @error('count') is-invalid @enderror" value="{{ old('count') }}" required placeholder="উদাঃ 568">
                        @error('count')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-3 form-group">
                        <label for="suffix">সাফিক্স / চিহ্ন</label>
                        <input type="text" name="suffix" id="suffix" class="form-control @error('suffix') is-invalid @enderror" value="{{ old('suffix', '+') }}" placeholder="উদাঃ + বা %">
                        @error('suffix')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="icon">ফন্টঅসাম আইকন ক্লাস (FontAwesome Icon Class)</label>
                        <input type="text" name="icon" id="icon" class="form-control @error('icon') is-invalid @enderror" value="{{ old('icon', 'fas fa-check-double') }}" placeholder="উদাঃ fas fa-check-double বা fas fa-smile">
                        <small class="form-text text-muted">FontAwesome আইকন কোড ব্যবহার করুন (যেমনঃ fas fa-trophy, fas fa-chart-line, fas fa-users)</small>
                        @error('icon')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="image">অথবা কাস্টম আইকন ছবি আপলোড করুন</label>
                        <input type="file" name="image" id="image" class="form-control-file @error('image') is-invalid @enderror" accept="image/*">
                        <small class="form-text text-muted">আইকন ইমেজ থাকলে এটি অগ্রাধিকার পাবে (PNG/SVG recommended)</small>
                        @error('image')
                            <span class="invalid-feedback d-block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-md-4 form-group">
                        <label for="order">প্রদর্শনের ক্রম (Order)</label>
                        <input type="number" name="order" id="order" class="form-control @error('order') is-invalid @enderror" value="{{ old('order', 0) }}" min="0">
                        @error('order')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-8 form-group d-flex align-items-center mt-4">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" name="is_active" class="custom-control-input" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                            <label class="custom-control-label font-weight-bold" for="is_active">ওয়েবসাইটে সক্রিয় থাকবে (Active)</label>
                        </div>
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
