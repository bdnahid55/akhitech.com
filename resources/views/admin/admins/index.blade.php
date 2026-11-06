@extends('admin.layouts.app')

@section('title', 'এডমিন একাউন্টস')
@section('page_title', 'এডমিন একাউন্ট ম্যানেজমেন্ট')

@section('content')
    <div class="card card-outline card-primary shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title font-weight-bold">সকল এডমিন ইউজারবৃন্দ</h3>
            <a href="{{ route('admin.admins.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-user-plus mr-1"></i> নতুন এডমিন যুক্ত করুন
            </a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped mb-0">
                    <thead>
                        <tr>
                            <th style="width: 50px;">#</th>
                            <th>এডমিনের নাম</th>
                            <th>ইমেইল এড্রেস</th>
                            <th>তৈরির তারিখ</th>
                            <th>স্ট্যাটাস</th>
                            <th style="width: 150px;" class="text-right">অ্যাকশন</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($admins as $index => $admin)
                            <tr>
                                <td>{{ $admins->firstItem() + $index }}</td>
                                <td>
                                    <div class="font-weight-bold">
                                        <i class="fas fa-user-circle text-primary mr-1"></i> {{ $admin->name }}
                                    </div>
                                </td>
                                <td>
                                    <span class="text-muted">{{ $admin->email }}</span>
                                </td>
                                <td>
                                    <small class="text-muted">{{ $admin->created_at?->format('d M, Y h:i A') ?? '—' }}</small>
                                </td>
                                <td>
                                    @if ($admin->id === auth()->id())
                                        <span class="badge badge-success"><i class="fas fa-check-circle mr-1"></i>বর্তমান ইউজার</span>
                                    @else
                                        <span class="badge badge-secondary">এডমিন</span>
                                    @endif
                                </td>
                                <td class="text-right">
                                    <a href="{{ route('admin.admins.edit', $admin) }}" class="btn btn-sm btn-info mr-1" title="সম্পাদনা">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @if ($admin->id !== auth()->id())
                                        <form action="{{ route('admin.admins.destroy', $admin) }}" method="POST" class="d-inline" onsubmit="return confirm('আপনি কি নিশ্চিত এই এডমিন একাউন্টটি মুছে ফেলতে চান?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="ডিলিট">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    @else
                                        <button class="btn btn-sm btn-secondary" disabled title="নিজের একাউন্ট মোছা যাবে না">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">কোনো এডমিন একাউন্ট পাওয়া যায়নি।</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if ($admins->hasPages())
            <div class="card-footer clearfix">
                {{ $admins->links() }}
            </div>
        @endif
    </div>
@endsection
