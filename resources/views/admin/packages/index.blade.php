@extends('admin.layouts.app')

@section('title', 'প্যাকেজ / প্রাইসিং তালিকা')
@section('page_title', 'প্যাকেজ ম্যানেজমেন্ট')

@section('content')
    <div class="card card-outline card-primary shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title font-weight-bold">সকল প্যাকেজ সমূহ</h3>
            <a href="{{ route('admin.packages.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus-circle mr-1"></i> নতুন প্যাকেজ যুক্ত করুন
            </a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped mb-0">
                    <thead>
                        <tr>
                            <th style="width: 50px;">ক্রম</th>
                            <th>প্যাকেজের নাম</th>
                            <th>মূল্য ও সময়কাল</th>
                            <th>ফিচারসমূহ</th>
                            <th style="width: 100px;">হাইলাইট</th>
                            <th style="width: 100px;">স্ট্যাটাস</th>
                            <th style="width: 150px;" class="text-right">অ্যাকশন</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($packages as $package)
                            <tr>
                                <td>{{ $package->order }}</td>
                                <td>
                                    <div class="font-weight-bold">{{ $package->name }}</div>
                                    <small class="text-muted">{{ $package->slug }}</small>
                                </td>
                                <td>
                                    <div class="text-success font-weight-bold">
                                        {{ $package->currency }}{{ $package->price }}
                                    </div>
                                    @if ($package->period)
                                        <small class="text-muted">{{ $package->period }}</small>
                                    @endif
                                </td>
                                <td>
                                    @if (!empty($package->features) && is_array($package->features))
                                        <span class="badge badge-info">{{ count($package->features) }} টি ফিচার</span>
                                        <div class="small text-muted mt-1">{{ Str::limit(implode(', ', $package->features), 50) }}</div>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($package->is_featured)
                                        <span class="badge badge-warning text-dark"><i class="fas fa-star mr-1"></i>ফিচার্ড</span>
                                    @else
                                        <span class="badge badge-light border">সাধারণ</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($package->is_active)
                                        <span class="badge badge-success">সক্রিয়</span>
                                    @else
                                        <span class="badge badge-secondary">নিষ্ক্রিয়</span>
                                    @endif
                                </td>
                                <td class="text-right">
                                    <a href="{{ route('admin.packages.edit', $package) }}" class="btn btn-sm btn-info mr-1" title="এডিট">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.packages.destroy', $package) }}" method="POST" class="d-inline" onsubmit="return confirm('আপনি কি নিশ্চিত এই প্যাকেজটি মুছে ফেলতে চান?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="ডিলিট">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">কোনো প্যাকেজ পাওয়া যায়নি। "নতুন প্যাকেজ যুক্ত করুন" বাটনে ক্লিক করে প্যাকেজ যোগ করুন।</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if ($packages->hasPages())
            <div class="card-footer clearfix">
                {{ $packages->links() }}
            </div>
        @endif
    </div>
@endsection
