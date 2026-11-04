@extends('admin.layouts.app')

@section('title', 'সার্ভিস তালিকা')
@section('page_title', 'সার্ভিস ম্যানেজমেন্ট')

@section('content')
    <div class="card card-outline card-primary shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title font-weight-bold">সকল সার্ভিস সমূহ</h3>
            <a href="{{ route('admin.services.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus-circle mr-1"></i> নতুন সার্ভিস যুক্ত করুন
            </a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped mb-0">
                    <thead>
                        <tr>
                            <th style="width: 50px;">ক্রম</th>
                            <th style="width: 60px;">আইকন</th>
                            <th>শিরোনাম</th>
                            <th>শুরুর মূল্য</th>
                            <th>স্ট্যাটাস</th>
                            <th style="width: 150px;" class="text-right">অ্যাকশন</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($services as $service)
                            <tr>
                                <td>{{ $service->order }}</td>
                                <td>
                                    <span class="badge badge-light border p-2">
                                        <i class="{{ $service->icon ?: 'fas fa-cube' }} fa-lg"></i>
                                    </span>
                                </td>
                                <td>
                                    <div class="font-weight-bold">{{ $service->title }}</div>
                                    <small class="text-muted">{{ Str::limit($service->short_description, 70) }}</small>
                                </td>
                                <td>
                                    @if ($service->starting_price)
                                        <span class="text-success font-weight-bold">৳{{ number_format($service->starting_price) }}</span>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($service->is_active)
                                        <span class="badge badge-success">সক্রিয়</span>
                                    @else
                                        <span class="badge badge-secondary">নিষ্ক্রিয়</span>
                                    @endif
                                </td>
                                <td class="text-right">
                                    <a href="{{ route('admin.services.edit', $service) }}" class="btn btn-sm btn-info mr-1">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.services.destroy', $service) }}" method="POST" class="d-inline" onsubmit="return confirm('আপনি কি নিশ্চিত এই সার্ভিসটি মুছে ফেলতে চান?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">কোনো সার্ভিস যোগ করা হয়নি।</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if ($services->hasPages())
            <div class="card-footer clearfix">
                {{ $services->links() }}
            </div>
        @endif
    </div>
@endsection
