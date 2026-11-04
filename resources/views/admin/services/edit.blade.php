@extends('admin.layouts.app')

@section('title', 'সার্ভিস সম্পাদনা')
@section('page_title', 'সার্ভিস তথ্য পরিবর্তন')

@section('content')
    <div class="card card-outline card-info shadow-sm">
        <div class="card-header">
            <h3 class="card-title font-weight-bold">সম্পাদনা: {{ $service->title }}</h3>
            <div class="card-tools">
                <a href="{{ route('admin.services.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left mr-1"></i> তালিকায় ফিরে যান
                </a>
            </div>
        </div>
        <form action="{{ route('admin.services.update', $service) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="title">সার্ভিসের নাম <span class="text-danger">*</span></label>
                        <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $service->title) }}" required>
                        @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="slug">স্লাগ</label>
                        <input type="text" name="slug" id="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug', $service->slug) }}">
                        @error('slug') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 form-group">
                        <label for="icon">ফন্টঅসাম আইকন ক্লাস</label>
                        <input type="text" name="icon" id="icon" class="form-control @error('icon') is-invalid @enderror" value="{{ old('icon', $service->icon) }}">
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="starting_price">শুরুর মূল্য (টাকা)</label>
                        <input type="number" name="starting_price" id="starting_price" class="form-control @error('starting_price') is-invalid @enderror" value="{{ old('starting_price', $service->starting_price) }}">
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="order">ক্রমিক নম্বর</label>
                        <input type="number" name="order" id="order" class="form-control @error('order') is-invalid @enderror" value="{{ old('order', $service->order) }}">
                    </div>
                </div>

                <div class="form-group">
                    <label for="short_description">সংক্ষিপ্ত বিবরণ <span class="text-danger">*</span></label>
                    <textarea name="short_description" id="short_description" rows="3" class="form-control @error('short_description') is-invalid @enderror" required>{{ old('short_description', $service->short_description) }}</textarea>
                    @error('short_description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label for="description">বিস্তারিত বিবরণ</label>
                    <textarea name="description" id="description" class="form-control summernote">{{ old('description', $service->description) }}</textarea>
                </div>

                <div class="form-check mb-3">
                    <input type="checkbox" name="is_active" value="1" class="form-check-input" id="is_active" {{ old('is_active', $service->is_active) ? 'checked' : '' }}>
                    <label class="form-check-label font-weight-bold" for="is_active">সার্ভিসটি সক্রিয় রাখুন (ওয়েবসাইটে প্রদর্শিত হবে)</label>
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
