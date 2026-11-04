@extends('admin.layouts.app')

@section('title', 'টিম মেম্বার তালিকা')
@section('page_title', 'টিম ম্যানেজমেন্ট')

@section('content')
    <div class="card card-outline card-primary shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title font-weight-bold">সকল টিম মেম্বারদের তালিকা</h3>
            <a href="{{ route('admin.team.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus-circle mr-1"></i> নতুন মেম্বার যুক্ত করুন
            </a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped mb-0">
                    <thead>
                        <tr>
                            <th style="width: 60px;">ছবি</th>
                            <th>নাম</th>
                            <th>পদবী</th>
                            <th>সোশ্যাল মিডিয়া</th>
                            <th style="width: 70px;">ক্রম</th>
                            <th style="width: 90px;">স্ট্যাটাস</th>
                            <th style="width: 140px;" class="text-right">অ্যাকশন</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($teamMembers as $member)
                            <tr>
                                <td>
                                    @if ($member->image)
                                        <img src="{{ asset($member->image) }}" alt="{{ $member->name }}" class="rounded-circle border" style="width: 45px; height: 45px; object-fit: cover;">
                                    @else
                                        <div class="bg-secondary rounded-circle text-center d-flex align-items-center justify-content-center text-white" style="width: 45px; height: 45px;">
                                            <i class="fas fa-user"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <div class="font-weight-bold">{{ $member->name }}</div>
                                </td>
                                <td>
                                    <span class="badge badge-info">{{ $member->designation }}</span>
                                </td>
                                <td>
                                    <div class="d-flex gap-1">
                                        @if ($member->facebook)
                                            <a href="{{ $member->facebook }}" target="_blank" class="btn btn-xs btn-outline-primary mr-1"><i class="fab fa-facebook-f"></i></a>
                                        @endif
                                        @if ($member->twitter)
                                            <a href="{{ $member->twitter }}" target="_blank" class="btn btn-xs btn-outline-info mr-1"><i class="fab fa-twitter"></i></a>
                                        @endif
                                        @if ($member->linkedin)
                                            <a href="{{ $member->linkedin }}" target="_blank" class="btn btn-xs btn-outline-primary mr-1"><i class="fab fa-linkedin-in"></i></a>
                                        @endif
                                        @if ($member->behance)
                                            <a href="{{ $member->behance }}" target="_blank" class="btn btn-xs btn-outline-dark mr-1"><i class="fab fa-behance"></i></a>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <span class="badge badge-light border">{{ $member->order }}</span>
                                </td>
                                <td>
                                    @if ($member->is_active)
                                        <span class="badge badge-success">সক্রিয়</span>
                                    @else
                                        <span class="badge badge-secondary">নিষ্ক্রিয়</span>
                                    @endif
                                </td>
                                <td class="text-right">
                                    <a href="{{ route('admin.team.edit', $member) }}" class="btn btn-sm btn-info mr-1" title="এডিট করুন">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.team.destroy', $member) }}" method="POST" class="d-inline" onsubmit="return confirm('আপনি কি নিশ্চিত এই টিম মেম্বারকে মুছে ফেলতে চান?');">
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
                                    কোনো টিম মেম্বার পাওয়া যায়নি।
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if ($teamMembers->hasPages())
            <div class="card-footer clearfix">
                {{ $teamMembers->links() }}
            </div>
        @endif
    </div>
@endsection
