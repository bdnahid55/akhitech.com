@extends('admin.layouts.app')

@section('title', 'প্রশংসাপত্র / রিভিউ তালিকা')
@section('page_title', 'প্রশংসাপত্র ম্যানেজমেন্ট')

@section('content')
    <div class="card card-outline card-primary shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title font-weight-bold">সকল প্রশংসাপত্র ও রিভিউ</h3>
            <a href="{{ route('admin.testimonials.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus-circle mr-1"></i> নতুন প্রশংসাপত্র যোগ করুন
            </a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped mb-0">
                    <thead>
                        <tr>
                            <th style="width: 60px;">ছবি</th>
                            <th>ক্লায়েন্টের নাম ও পদবী</th>
                            <th>মন্তব্য / রিভিউ</th>
                            <th style="width: 120px;">রেটিং</th>
                            <th style="width: 70px;">ক্রম</th>
                            <th style="width: 90px;">স্ট্যাটাস</th>
                            <th style="width: 140px;" class="text-right">অ্যাকশন</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($testimonials as $testimonial)
                            <tr>
                                <td>
                                    @if ($testimonial->image)
                                        <img src="{{ asset($testimonial->image) }}" alt="{{ $testimonial->name }}" class="rounded-circle border" style="width: 45px; height: 45px; object-fit: cover;">
                                    @else
                                        <div class="bg-secondary rounded-circle text-center d-flex align-items-center justify-content-center text-white" style="width: 45px; height: 45px;">
                                            <i class="fas fa-user"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <div class="font-weight-bold">{{ $testimonial->name }}</div>
                                    <small class="text-muted">{{ $testimonial->designation ?? '—' }}</small>
                                </td>
                                <td>
                                    <span title="{{ $testimonial->comment }}">{{ Str::limit($testimonial->comment, 80) }}</span>
                                </td>
                                <td>
                                    <div class="text-warning">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= $testimonial->rating)
                                                <i class="fas fa-star fa-xs"></i>
                                            @else
                                                <i class="far fa-star fa-xs"></i>
                                            @endif
                                        @endfor
                                        <small class="text-muted font-weight-bold ml-1">({{ $testimonial->rating }})</small>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge badge-light border">{{ $testimonial->order }}</span>
                                </td>
                                <td>
                                    @if ($testimonial->is_active)
                                        <span class="badge badge-success">সক্রিয়</span>
                                    @else
                                        <span class="badge badge-secondary">নিষ্ক্রিয়</span>
                                    @endif
                                </td>
                                <td class="text-right">
                                    <a href="{{ route('admin.testimonials.edit', $testimonial) }}" class="btn btn-sm btn-info mr-1" title="এডিট করুন">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.testimonials.destroy', $testimonial) }}" method="POST" class="d-inline" onsubmit="return confirm('আপনি কি নিশ্চিত এই প্রশংসাপত্রটি মুছে ফেলতে চান?');">
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
                                    কোনো প্রশংসাপত্র পাওয়া যায়নি।
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if ($testimonials->hasPages())
            <div class="card-footer clearfix">
                {{ $testimonials->links() }}
            </div>
        @endif
    </div>
@endsection
