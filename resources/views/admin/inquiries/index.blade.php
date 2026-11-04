@extends('admin.layouts.app')

@section('title', 'বার্তা ও কোটেশন তালিকা')
@section('page_title', 'গ্রাহক অনুসন্ধান ও কোটেশন রিকোয়েস্ট')

@section('content')
    <div class="card card-outline card-primary shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <a href="{{ route('admin.inquiries.index') }}" class="btn btn-sm {{ empty($type) ? 'btn-primary' : 'btn-outline-primary' }} mr-1">
                    সকল বার্তা ({{ \App\Models\Inquiry::count() }})
                </a>
                <a href="{{ route('admin.inquiries.index', ['type' => 'contact']) }}" class="btn btn-sm {{ $type === 'contact' ? 'btn-secondary' : 'btn-outline-secondary' }} mr-1">
                    <i class="fas fa-envelope mr-1"></i> যোগাযোগ ({{ \App\Models\Inquiry::where('type', 'contact')->count() }})
                </a>
                <a href="{{ route('admin.inquiries.index', ['type' => 'quote']) }}" class="btn btn-sm {{ $type === 'quote' ? 'btn-info' : 'btn-outline-info' }}">
                    <i class="fas fa-file-invoice-dollar mr-1"></i> কোটেশন ({{ \App\Models\Inquiry::where('type', 'quote')->count() }})
                </a>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped mb-0">
                    <thead>
                        <tr>
                            <th style="width: 70px;">স্ট্যাটাস</th>
                            <th style="width: 90px;">ধরন</th>
                            <th>গ্রাহকের নাম</th>
                            <th>ইমেইল ও মোবাইল</th>
                            <th>বিষয় / প্রজেক্ট</th>
                            <th>প্রাপ্তির সময়</th>
                            <th style="width: 120px;" class="text-right">অ্যাকশন</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($inquiries as $inquiry)
                            <tr class="{{ ! $inquiry->is_read ? 'table-warning' : '' }}">
                                <td>
                                    @if ($inquiry->is_read)
                                        <span class="badge badge-light border text-muted">পঠিত</span>
                                    @else
                                        <span class="badge badge-warning">নতুন</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($inquiry->type === 'quote')
                                        <span class="badge badge-info">কোটেশন</span>
                                    @else
                                        <span class="badge badge-secondary">যোগাযোগ</span>
                                    @endif
                                </td>
                                <td class="font-weight-bold">{{ $inquiry->name }}</td>
                                <td>
                                    <div><a href="mailto:{{ $inquiry->email }}">{{ $inquiry->email }}</a></div>
                                    @if ($inquiry->phone)
                                        <small><a href="tel:{{ $inquiry->phone }}" class="text-muted"><i class="fas fa-phone mr-1"></i>{{ $inquiry->phone }}</a></small>
                                    @endif
                                </td>
                                <td>{{ Str::limit($inquiry->subject, 35) }}</td>
                                <td><small class="text-muted">{{ $inquiry->created_at->format('d M, Y h:i A') }}</small></td>
                                <td class="text-right">
                                    <a href="{{ route('admin.inquiries.show', $inquiry) }}" class="btn btn-sm btn-primary mr-1" title="বিস্তারিত দেখুন">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <form action="{{ route('admin.inquiries.destroy', $inquiry) }}" method="POST" class="d-inline" onsubmit="return confirm('আপনি কি নিশ্চিত এই বার্তাটি মুছে ফেলতে চান?');">
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
                                <td colspan="7" class="text-center py-4 text-muted">কোনো বার্তা পাওয়া যায়নি।</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if ($inquiries->hasPages())
            <div class="card-footer clearfix">
                {{ $inquiries->links() }}
            </div>
        @endif
    </div>
@endsection
