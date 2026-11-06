@extends('admin.layouts.app')

@section('title', 'এডমিন একাউন্ট সম্পাদনা')
@section('page_title', 'এডমিন একাউন্ট সম্পাদনা')

@section('content')
    <div class="card card-outline card-primary shadow-sm" style="max-width: 750px;">
        <div class="card-header">
            <h3 class="card-title font-weight-bold">এডমিন একাউন্ট তথ্য আপডেট করুন</h3>
            <div class="card-tools">
                <a href="{{ route('admin.admins.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left mr-1"></i> তালিকায় ফিরে যান
                </a>
            </div>
        </div>
        <form action="{{ route('admin.admins.update', $admin) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="form-group">
                    <label for="name">এডমিনের পূর্ণ নাম <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                        </div>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $admin->name) }}" required>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="email">ইমেইল এড্রেস <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        </div>
                        <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $admin->email) }}" required>
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label class="d-block font-weight-bold">রোল নির্ধারণ করুন (Roles)</label>
                    <p class="text-muted small mb-2">এই এডমিনের জন্য এক বা একাধিক রোল নির্বাচন করুন।</p>
                    <div class="p-3 border rounded bg-light">
                        <div class="row">
                            @php
                                $selectedRoles = old('roles', $adminRoles);
                            @endphp
                            @forelse ($roles as $role)
                                <div class="col-md-6 mb-2">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox"
                                               name="roles[]"
                                               value="{{ $role->name }}"
                                               class="custom-control-input"
                                               id="role_{{ $role->id }}"
                                               {{ in_array($role->name, $selectedRoles, true) ? 'checked' : '' }}>
                                        <label class="custom-control-label font-weight-normal" for="role_{{ $role->id }}">
                                            <strong>{{ $role->name }}</strong>
                                            @if ($role->name === 'Super Admin')
                                                <span class="badge badge-danger ml-1">পূর্ণ নিয়ন্ত্রণ</span>
                                            @endif
                                            <div class="text-muted small">পারমিশন সংখ্যা: {{ $role->permissions->count() }}টি</div>
                                        </label>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12 text-muted">কোনো রোল পাওয়া যায়নি।</div>
                            @endforelse
                        </div>
                    </div>
                    @error('roles') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="alert alert-info py-2 px-3 mb-3">
                    <small class="d-block mb-1"><i class="fas fa-info-circle mr-1"></i> পাসওয়ার্ড পরিবর্তন করতে না চাইলে নিচের পাসওয়ার্ড ঘরগুলো ফাঁকা রাখুন।</small>
                    <small class="d-block"><i class="fas fa-shield-alt mr-1"></i> <strong>স্ট্রং পাসওয়ার্ড নীতিমালা:</strong> পাসওয়ার্ডে কমপক্ষে ৮ অক্ষর, বড় হাতের অক্ষর (A-Z), ছোট হাতের অক্ষর (a-z), সংখ্যা (0-9) এবং স্পেশাল ক্যারেক্টার থাকতে হবে।</small>
                </div>

                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="password">নতুন পাসওয়ার্ড (ঐচ্ছিক)</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            </div>
                            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="কমপক্ষে ৮ অক্ষর">
                            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="password_confirmation">নতুন পাসওয়ার্ড নিশ্চিত করুন</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-check-double"></i></span>
                            </div>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="পুনরায় নতুন পাসওয়ার্ড লিখুন">
                        </div>
                    </div>
                </div>

                <div class="form-group bg-light p-3 border rounded">
                    <label for="current_password">
                        <i class="fas fa-user-lock text-warning mr-1"></i> আপনার বর্তমান পাসওয়ার্ড (Re-authentication)
                    </label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-key"></i></span>
                        </div>
                        <input type="password" name="current_password" id="current_password" class="form-control @error('current_password') is-invalid @enderror" placeholder="নতুন পাসওয়ার্ড সেট করতে আপনার বর্তমান পাসওয়ার্ড লিখুন">
                        @error('current_password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <small class="form-text text-muted">নিরাপত্তার স্বার্থে পাসওয়ার্ড পরিবর্তন করতে আপনার বর্তমান পাসওয়ার্ড দিয়ে নিশ্চিত করতে হবে।</small>
                </div>
            </div>
            <div class="card-footer bg-light">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save mr-1"></i> আপডেট সংরক্ষণ করুন
                </button>
                <a href="{{ route('admin.admins.index') }}" class="btn btn-secondary">বাতিল</a>
            </div>
        </form>
    </div>
@endsection
