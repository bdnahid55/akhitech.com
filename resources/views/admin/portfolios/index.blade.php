@extends('admin.layouts.app')

@section('title', 'পোর্টফোলিও তালিকা')
@section('page_title', 'পোর্টফোলিও ম্যানেজমেন্ট')

@section('content')
    <div class="card card-outline card-success shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title font-weight-bold">সকল প্রজেক্ট সমূহ</h3>
            <a href="{{ route('admin.portfolios.create') }}" class="btn btn-success btn-sm">
                <i class="fas fa-plus-circle mr-1"></i> নতুন প্রজেক্ট যুক্ত করুন
            </a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped mb-0">
                    <thead>
                        <tr>
                            <th style="width: 80px;">ছবি</th>
                            <th>শিরোনাম</th>
                            <th>ক্যাটাগরি</th>
                            <th>ক্লায়েন্ট</th>
                            <th>ফিচার্ড</th>
                            <th>স্ট্যাটাস</th>
                            <th style="width: 150px;" class="text-right">অ্যাকশন</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($portfolios as $portfolio)
                            <tr>
                                <td>
                                    <img src="{{ $portfolio->image ? asset($portfolio->image) : asset('assets/front/img/portfolio/1736978150325788965.png') }}" alt="{{ $portfolio->title }}" class="img-thumbnail" style="width: 60px; height: 45px; object-fit: cover;">
                                </td>
                                <td>
                                    <div class="font-weight-bold">{{ $portfolio->title }}</div>
                                    @if ($portfolio->project_url)
                                        <a href="{{ $portfolio->project_url }}" target="_blank" class="small text-muted">
                                            <i class="fas fa-link mr-1"></i> {{ $portfolio->project_url }}
                                        </a>
                                    @endif
                                </td>
                                <td><span class="badge badge-light border">{{ $portfolio->category }}</span></td>
                                <td>{{ $portfolio->client_name ?: '—' }}</td>
                                <td>
                                    @if ($portfolio->is_featured)
                                        <span class="badge badge-info">ফিচার্ড</span>
                                    @else
                                        <span class="badge badge-light border">সাধারণ</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($portfolio->is_active)
                                        <span class="badge badge-success">সক্রিয়</span>
                                    @else
                                        <span class="badge badge-secondary">নিষ্ক্রিয়</span>
                                    @endif
                                </td>
                                <td class="text-right">
                                    <a href="{{ route('admin.portfolios.edit', $portfolio) }}" class="btn btn-sm btn-info mr-1">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.portfolios.destroy', $portfolio) }}" method="POST" class="d-inline" onsubmit="return confirm('আপনি কি নিশ্চিত এই প্রজেক্টটি মুছে ফেলতে চান?');">
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
                                <td colspan="7" class="text-center py-4 text-muted">কোনো পোর্টফোলিও প্রজেক্ট পাওয়া যায়নি।</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if ($portfolios->hasPages())
            <div class="card-footer clearfix">
                {{ $portfolios->links() }}
            </div>
        @endif
    </div>
@endsection
