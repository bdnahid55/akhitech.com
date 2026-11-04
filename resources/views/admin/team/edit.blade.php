@extends('admin.layouts.app')

@section('title', 'টিম মেম্বার সম্পাদনা')
@section('page_title', 'টিম মেম্বার সম্পাদনা')

@section('content')
    <div class="card card-outline card-primary shadow-sm">
        <div class="card-header">
            <h3 class="card-title font-weight-bold">সদস্যের তথ্য সম্পাদনা করুন</h3>
            <div class="card-tools">
                <a href="{{ route('admin.team.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left mr-1"></i> ফিরে যান
                </a>
            </div>
        </div>

        <form action="{{ route('admin.team.update', $member) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="name">নাম <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $member->name) }}" required>
                        @error('name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="slug">স্লাগ / URL (ঐচ্ছিক)</label>
                        <input type="text" name="slug" id="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug', $member->slug) }}">
                        @error('slug')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="designation">পদবী <span class="text-danger">*</span></label>
                        <input type="text" name="designation" id="designation" class="form-control @error('designation') is-invalid @enderror" value="{{ old('designation', $member->designation) }}" required>
                        @error('designation')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="image">ছবি</label>
                        @if ($member->image)
                            <div class="mb-2">
                                <img src="{{ asset($member->image) }}" alt="{{ $member->name }}" class="rounded-circle border" style="width: 50px; height: 50px; object-fit: cover;">
                            </div>
                        @endif
                        <input type="file" name="image" id="image" class="form-control-file @error('image') is-invalid @enderror" accept="image/*">
                        <small class="form-text text-muted">পরিবর্তন করতে চাইলে নতুন ছবি আপলোড করুন</small>
                        @error('image')
                            <span class="invalid-feedback d-block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="bio">সংক্ষিপ্ত পরিচিতি / বায়ো</label>
                    <textarea name="bio" id="bio" rows="4" class="form-control @error('bio') is-invalid @enderror">{{ old('bio', $member->bio) }}</textarea>
                    @error('bio')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-3 form-group">
                        <label for="facebook"><i class="fab fa-facebook text-primary mr-1"></i> ফেসবুক লিংক</label>
                        <input type="url" name="facebook" id="facebook" class="form-control @error('facebook') is-invalid @enderror" value="{{ old('facebook', $member->facebook) }}" placeholder="https://facebook.com/username">
                        @error('facebook')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-3 form-group">
                        <label for="twitter"><i class="fab fa-twitter text-info mr-1"></i> টুইটার / এক্স লিংক</label>
                        <input type="url" name="twitter" id="twitter" class="form-control @error('twitter') is-invalid @enderror" value="{{ old('twitter', $member->twitter) }}" placeholder="https://twitter.com/username">
                        @error('twitter')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-3 form-group">
                        <label for="linkedin"><i class="fab fa-linkedin text-primary mr-1"></i> লিঙ্কডইন লিংক</label>
                        <input type="url" name="linkedin" id="linkedin" class="form-control @error('linkedin') is-invalid @enderror" value="{{ old('linkedin', $member->linkedin) }}" placeholder="https://linkedin.com/in/username">
                        @error('linkedin')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-3 form-group">
                        <label for="behance"><i class="fab fa-behance text-dark mr-1"></i> বিহান্স লিংক</label>
                        <input type="url" name="behance" id="behance" class="form-control @error('behance') is-invalid @enderror" value="{{ old('behance', $member->behance) }}" placeholder="https://behance.net/username">
                        @error('behance')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-md-4 form-group">
                        <label for="order">প্রদর্শনের ক্রম (Order)</label>
                        <input type="number" name="order" id="order" class="form-control @error('order') is-invalid @enderror" value="{{ old('order', $member->order) }}" min="0">
                        @error('order')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-8 form-group d-flex align-items-center mt-4">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" name="is_active" class="custom-control-input" id="is_active" value="1" {{ old('is_active', $member->is_active) ? 'checked' : '' }}>
                            <label class="custom-control-label font-weight-bold" for="is_active">ওয়েবসাইটে সক্রিয় থাকবে (Active)</label>
                        </div>
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
