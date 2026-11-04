@extends('admin.layouts.app')

@section('title', 'বার্তা বিস্তারিত')
@section('page_title', 'গ্রাহকের বার্তার বিবরণ')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="card card-outline card-primary shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title font-weight-bold">
                        @if ($inquiry->type === 'quote')
                            <span class="badge badge-info mr-2">ফ্রি কনসালটেশন / কোটেশন</span>
                        @else
                            <span class="badge badge-secondary mr-2">যোগাযোগ বার্তা</span>
                        @endif
                        {{ $inquiry->subject }}
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.inquiries.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left mr-1"></i> তালিকায় ফিরে যান
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-4 border-bottom pb-3">
                        <div class="col-sm-6">
                            <p class="mb-1 text-muted">প্রেরক:</p>
                            <h4 class="font-weight-bold text-dark">{{ $inquiry->name }}</h4>
                            <div><i class="fas fa-envelope mr-1 text-muted"></i> <a href="mailto:{{ $inquiry->email }}">{{ $inquiry->email }}</a></div>
                            @if ($inquiry->phone)
                                <div><i class="fas fa-phone mr-1 text-muted"></i> <a href="tel:{{ $inquiry->phone }}">{{ $inquiry->phone }}</a></div>
                            @endif
                        </div>
                        <div class="col-sm-6 text-sm-right mt-3 mt-sm-0">
                            <p class="mb-1 text-muted">প্রাপ্তির তারিখ ও সময়:</p>
                            <span class="font-weight-bold">{{ $inquiry->created_at->format('d F, Y (h:i A)') }}</span>
                            <div class="text-muted small">{{ $inquiry->created_at->diffForHumans() }}</div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h5 class="font-weight-bold text-dark">বিষয় / প্রজেক্ট:</h5>
                        <p class="lead bg-light p-3 rounded border">{{ $inquiry->subject }}</p>
                    </div>

                    <div class="mb-4">
                        <h5 class="font-weight-bold text-dark">বার্তার মূল বিবরণ:</h5>
                        <div class="p-4 bg-white border rounded shadow-xs" style="white-space: pre-wrap; line-height: 1.8;">{{ $inquiry->message }}</div>
                    </div>

                    <div class="d-flex justify-content-between pt-3 border-top">
                        <a href="mailto:{{ $inquiry->email }}?subject=Re: {{ urlencode($inquiry->subject) }}" class="btn btn-primary">
                            <i class="fas fa-reply mr-1"></i> ইমেইলে উত্তর দিন
                        </a>

                        <form action="{{ route('admin.inquiries.destroy', $inquiry) }}" method="POST" onsubmit="return confirm('আপনি কি নিশ্চিত এই বার্তাটি মুছে ফেলতে চান?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash-alt mr-1"></i> মুছে ফেলুন
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
