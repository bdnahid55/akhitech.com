@extends('admin.layouts.app')

@section('title', 'অর্জন ও কাউন্টার তালিকা')
@section('page_title', 'অর্জন ও কাউন্টার ম্যানেজমেন্ট')

@section('content')
    <div class="card card-outline card-primary shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title font-weight-bold">সকল অর্জন ও কাউন্টার কার্ড</h3>
            <a href="{{ route('admin.achievements.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus-circle mr-1"></i> নতুন অর্জন যোগ করুন
            </a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped mb-0">
                    <thead>
                        <tr>
                            <th style="width: 70px;">আইকন</th>
                            <th>শিরোনাম</th>
                            <th>কাউন্ট / সংখ্যা</th>
                            <th>সাফিক্স</th>
                            <th style="width: 70px;">ক্রম</th>
                            <th style="width: 90px;">স্ট্যাটাস</th>
                            <th style="width: 140px;" class="text-right">অ্যাকশন</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($achievements as $achievement)
                            <tr>
                                <td>
                                    <div class="bg-dark rounded-circle text-center d-flex align-items-center justify-content-center text-white" style="width: 45px; height: 45px;">
                                        @if ($achievement->image)
                                            <img src="{{ asset($achievement->image) }}" alt="icon" style="max-height: 25px; max-width: 25px;">
                                        @elseif ($achievement->icon)
                                            <i class="{{ $achievement->icon }}"></i>
                                        @else
                                            <i class="fas fa-trophy"></i>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="font-weight-bold">{{ $achievement->title }}</div>
                                </td>
                                <td>
                                    <span class="badge badge-success font-weight-bold p-2" style="font-size: 14px;">{{ $achievement->count }}</span>
                                </td>
                                <td>
                                    <code>{{ $achievement->suffix ?? '+' }}</code>
                                </td>
                                <td>
                                    <span class="badge badge-light border">{{ $achievement->order }}</span>
                                </td>
                                <td>
                                    @if ($achievement->is_active)
                                        <span class="badge badge-success">সক্রিয়</span>
                                    @else
                                        <span class="badge badge-secondary">নিষ্ক্রিয়</span>
                                    @endif
                                </td>
                                <td class="text-right">
                                    <a href="{{ route('admin.achievements.edit', $achievement) }}" class="btn btn-sm btn-info mr-1" title="এডিট করুন">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.achievements.destroy', $achievement) }}" method="POST" class="d-inline" onsubmit="return confirm('আপনি কি নিশ্চিত এই অর্জনটি মুছে ফেলতে চান?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="মুছে ফেলুন">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">
                                    কোনো অর্জন বা কাউন্টার পাওয়া যায়নি।
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if ($achievements->hasPages())
            <div class="card-footer clearfix">
                {{ $achievements->links() }}
            </div>
        @endif
    </div>
@endsection
