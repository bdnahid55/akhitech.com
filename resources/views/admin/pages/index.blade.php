@extends('admin.layouts.app')

@section('title', 'কাস্টম পেইজ তালিকা')
@section('page_title', 'কাস্টম পেইজ ম্যানেজমেন্ট')

@section('content')
    <div class="card card-outline card-primary shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title font-weight-bold">সকল কাস্টম পেইজ</h3>
            <a href="{{ route('admin.pages.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus-circle mr-1"></i> নতুন পেজ তৈরি করুন
            </a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped mb-0">
                    <thead>
                        <tr>
                            <th style="width: 50px;">ক্রম</th>
                            <th>পেজের নাম ও স্লাগ</th>
                            <th>মেনু অবস্থান (Placement)</th>
                            <th>প্যারেন্ট মেনু</th>
                            <th>স্ট্যাটাস</th>
                            <th style="width: 170px;" class="text-right">অ্যাকশন</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pages as $page)
                            <tr>
                                <td>{{ $page->order }}</td>
                                <td>
                                    <div class="font-weight-bold">{{ $page->title }}</div>
                                    <small class="text-muted"><code>/page/{{ $page->slug }}</code></small>
                                </td>
                                <td>
                                    @if ($page->show_in_header)
                                        <span class="badge badge-info mr-1"><i class="fas fa-heading mr-1"></i>হেডার মেনু</span>
                                    @endif
                                    @if ($page->show_in_footer)
                                        <span class="badge badge-secondary"><i class="fas fa-shoe-prints mr-1"></i>ফুটার ({{ $page->footer_column === 'legal' ? 'আইনি' : 'দ্রুত লিংক' }})</span>
                                    @endif
                                    @if (!$page->show_in_header && !$page->show_in_footer)
                                        <span class="text-muted font-italic">মেনুতে নেই (সরাসরি লিঙ্ক)</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($page->parent)
                                        <span class="badge badge-light border"><i class="fas fa-level-up-alt fa-rotate-90 mr-1"></i>{{ $page->parent->title }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($page->is_active)
                                        <span class="badge badge-success">সক্রিয়</span>
                                    @else
                                        <span class="badge badge-danger">নিষ্ক্রিয়</span>
                                    @endif
                                </td>
                                <td class="text-right">
                                    <a href="{{ route('page.show', $page->slug) }}" target="_blank" class="btn btn-sm btn-outline-secondary mr-1" title="পেজ দেখুন">
                                        <i class="fas fa-external-link-alt"></i>
                                    </a>
                                    <a href="{{ route('admin.pages.edit', $page) }}" class="btn btn-sm btn-info mr-1" title="সম্পাদনা">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.pages.destroy', $page) }}" method="POST" class="d-inline" onsubmit="return confirm('আপনি কি নিশ্চিত এই পেজটি মুছে ফেলতে চান?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="মুছে ফেলুন">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">কোনো কাস্টম পেজ পাওয়া যায়নি।</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if ($pages->hasPages())
            <div class="card-footer clearfix">
                {{ $pages->links() }}
            </div>
        @endif
    </div>
@endsection
