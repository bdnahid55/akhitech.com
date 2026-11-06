@extends('admin.layouts.app')

@section('title', 'নতুন রোল তৈরি')
@section('page_title', 'নতুন রোল ও পারমিশন তৈরি করুন')

@section('content')
    <form action="{{ route('admin.roles.store') }}" method="POST">
        @csrf
        <div class="card card-outline card-primary shadow-sm mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title font-weight-bold">রোলের প্রাথমিক তথ্য</h3>
                <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left mr-1"></i> তালিকায় ফিরে যান
                </a>
            </div>
            <div class="card-body">
                <div class="form-group mb-0" style="max-width: 500px;">
                    <label for="name">রোলের নাম <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-user-tag"></i></span>
                        </div>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="উদা: Content Manager, Support Admin" required>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <small class="form-text text-muted">একটি অনন্য রোলের নাম প্রদান করুন।</small>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h4 class="mb-0 font-weight-bold"><i class="fas fa-key text-warning mr-2"></i>পারমিশন নির্ধারণ করুন</h4>
                <small class="text-muted">এই রোলের জন্য যে যে মডিউলের এক্সেস প্রয়োজন সেগুলো সিলেক্ট করুন।</small>
            </div>
            <div>
                <button type="button" class="btn btn-outline-primary btn-sm" id="btnSelectAll">
                    <i class="fas fa-check-square mr-1"></i> সব পারমিশন সিলেক্ট করুন
                </button>
                <button type="button" class="btn btn-outline-secondary btn-sm ml-1" id="btnUnselectAll">
                    <i class="far fa-square mr-1"></i> সব আনচেক করুন
                </button>
            </div>
        </div>

        @error('permissions')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        <div class="row">
            @foreach ($modules as $moduleKey => $module)
                <div class="col-md-6 mb-4">
                    <div class="card card-outline card-secondary h-100 shadow-sm">
                        <div class="card-header bg-light d-flex justify-content-between align-items-center py-2">
                            <h5 class="card-title font-weight-bold text-dark mb-0">
                                <i class="fas fa-folder text-primary mr-1"></i> {{ $module['label'] }}
                            </h5>
                            <button type="button" class="btn btn-xs btn-link text-muted select-group-btn" data-group="{{ $moduleKey }}">
                                সিলেক্ট করুন
                            </button>
                        </div>
                        <div class="card-body p-3">
                            <div class="row">
                                @foreach ($module['permissions'] as $permKey => $permLabel)
                                    <div class="col-12 mb-2">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox"
                                                   name="permissions[]"
                                                   value="{{ $permKey }}"
                                                   class="custom-control-input perm-checkbox group-{{ $moduleKey }}"
                                                   id="perm_{{ Str::slug($permKey, '_') }}"
                                                   {{ (is_array(old('permissions')) && in_array($permKey, old('permissions'), true)) ? 'checked' : '' }}>
                                            <label class="custom-control-label font-weight-normal" for="perm_{{ Str::slug($permKey, '_') }}">
                                                <span>{{ $permLabel }}</span>
                                                <span class="badge badge-light border text-muted ml-1" style="font-size: 11px;">{{ $permKey }}</span>
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="card shadow-sm mt-2">
            <div class="card-body d-flex justify-content-between align-items-center">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="fas fa-save mr-1"></i> রোল সংরক্ষণ করুন
                </button>
                <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">বাতিল</a>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const checkboxes = document.querySelectorAll('.perm-checkbox');
        const btnSelectAll = document.getElementById('btnSelectAll');
        const btnUnselectAll = document.getElementById('btnUnselectAll');

        btnSelectAll?.addEventListener('click', function () {
            checkboxes.forEach(cb => cb.checked = true);
        });

        btnUnselectAll?.addEventListener('click', function () {
            checkboxes.forEach(cb => cb.checked = false);
        });

        document.querySelectorAll('.select-group-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                const group = this.getAttribute('data-group');
                const groupCheckboxes = document.querySelectorAll('.group-' + group);
                const allChecked = Array.from(groupCheckboxes).every(cb => cb.checked);
                groupCheckboxes.forEach(cb => cb.checked = !allChecked);
                this.textContent = allChecked ? 'সিলেক্ট করুন' : 'আনচেক করুন';
            });
        });
    });
</script>
@endpush
