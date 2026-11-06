@extends('admin.layouts.app')

@section('title', 'লগইন অ্যাক্টিভিটি')
@section('page_title', 'লগইন অ্যাক্টিভিটি ও সিকিউরিটি লগ')

@section('content')
    <!-- Summary Statistics -->
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info shadow-sm">
                <div class="inner">
                    <h3>{{ number_format($stats['total']) }}</h3>
                    <p>মোট লগইন রেকর্ড</p>
                </div>
                <div class="icon"><i class="fas fa-history"></i></div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success shadow-sm">
                <div class="inner">
                    <h3>{{ number_format($stats['successful']) }}</h3>
                    <p>সফল লগইন</p>
                </div>
                <div class="icon"><i class="fas fa-check-circle"></i></div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning shadow-sm">
                <div class="inner">
                    <h3>{{ number_format($stats['failed']) }}</h3>
                    <p>ব্যর্থ প্রচেষ্টা</p>
                </div>
                <div class="icon"><i class="fas fa-exclamation-triangle"></i></div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger shadow-sm">
                <div class="inner">
                    <h3>{{ number_format($stats['locked']) }}</h3>
                    <p>ব্লকড / লকড প্রচেষ্টা</p>
                </div>
                <div class="icon"><i class="fas fa-user-lock"></i></div>
            </div>
        </div>
    </div>

    <!-- Activities Table & Filter -->
    <div class="card card-outline card-primary shadow-sm">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <h3 class="card-title font-weight-bold mb-2 mb-md-0">
                    <i class="fas fa-shield-alt mr-1 text-primary"></i> লগইন প্রচেষ্টার বিস্তারিত তালিকা
                </h3>
                <div class="d-flex align-items-center flex-wrap">
                    @can('login_activities.delete')
                        @if ($activities->total() > 0)
                            <form action="{{ route('admin.login_activities.clear') }}" method="POST" class="mr-2 mb-2 mb-md-0" onsubmit="return confirm('আপনি কি নিশ্চিত সকল লগইন রেকর্ড মুছে ফেলতে চান?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="fas fa-trash-alt mr-1"></i> সকল হিস্টোরি ক্লিয়ার করুন
                                </button>
                            </form>
                        @endif
                    @endcan
                </div>
            </div>
        </div>

        <div class="card-body border-bottom bg-light py-2">
            <form action="{{ route('admin.login_activities.index') }}" method="GET" class="form-inline">
                <div class="form-group mr-2 mb-2">
                    <input type="text" name="search" class="form-control form-control-sm" placeholder="ইমেইল / আইপি দিয়ে খুঁজুন..." value="{{ request('search') }}">
                </div>
                <div class="form-group mr-2 mb-2">
                    <select name="status" class="form-control form-control-sm">
                        <option value="">সকল স্ট্যাটাস</option>
                        <option value="successful" {{ request('status') === 'successful' ? 'selected' : '' }}>সফল (Successful)</option>
                        <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>ব্যর্থ (Failed)</option>
                        <option value="locked" {{ request('status') === 'locked' ? 'selected' : '' }}>লকড (Locked)</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-sm btn-primary mb-2 mr-2">
                    <i class="fas fa-search mr-1"></i> ফিল্টার
                </button>
                @if (request()->hasAny(['search', 'status']))
                    <a href="{{ route('admin.login_activities.index') }}" class="btn btn-sm btn-secondary mb-2">
                        রিসেট
                    </a>
                @endif
            </form>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped mb-0">
                    <thead>
                        <tr>
                            <th style="width: 50px;">#</th>
                            <th>এডমিন / ইমেইল</th>
                            <th>আইপি এড্রেস (IP)</th>
                            <th>ডিভাইস ও ব্রাউজার</th>
                            <th>ফলাফল / স্ট্যাটাস</th>
                            <th>তারিখ ও সময়</th>
                            <th style="width: 80px;" class="text-right">অ্যাকশন</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($activities as $index => $activity)
                            <tr>
                                <td>{{ $activities->firstItem() + $index }}</td>
                                <td>
                                    <div class="font-weight-bold">
                                        @if ($activity->user)
                                            <i class="fas fa-user-circle text-primary mr-1"></i> {{ $activity->user->name }}
                                            <div class="text-muted small">{{ $activity->email }}</div>
                                        @else
                                            <i class="fas fa-envelope text-muted mr-1"></i> {{ $activity->email }}
                                            <div class="text-danger small">(অনিবন্ধিত / অজ্ঞাত)</div>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <code>{{ $activity->ip_address ?: '—' }}</code>
                                </td>
                                <td>
                                    <span class="badge badge-light border">
                                        <i class="fas fa-desktop mr-1 text-muted"></i>{{ $activity->device ?: 'Unknown' }}
                                    </span>
                                </td>
                                <td>
                                    @if ($activity->status === 'successful')
                                        <span class="badge badge-success px-2 py-1">
                                            <i class="fas fa-check mr-1"></i> সফল লগইন
                                        </span>
                                    @elseif ($activity->status === 'failed')
                                        <span class="badge badge-warning px-2 py-1">
                                            <i class="fas fa-times mr-1"></i> ভুল পাসওয়ার্ড
                                        </span>
                                    @elseif ($activity->status === 'locked')
                                        <span class="badge badge-danger px-2 py-1">
                                            <i class="fas fa-ban mr-1"></i> সাময়িক লকড
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <small class="text-muted">
                                        {{ $activity->created_at?->format('d M, Y h:i:s A') }}
                                        <span class="d-block text-secondary">({{ $activity->created_at?->diffForHumans() }})</span>
                                    </small>
                                </td>
                                <td class="text-right">
                                    @can('login_activities.delete')
                                        <form action="{{ route('admin.login_activities.destroy', $activity) }}" method="POST" class="d-inline" onsubmit="return confirm('এই রেকর্ডটি মুছে ফেলতে চান?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="মুছে ফেলুন">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    @endcan
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">কোনো লগইন রেকর্ড পাওয়া যায়নি।</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if ($activities->hasPages())
            <div class="card-footer clearfix">
                {{ $activities->links() }}
            </div>
        @endif
    </div>
@endsection
