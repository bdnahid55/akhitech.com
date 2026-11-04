@extends('admin.layouts.app')

@section('title', 'নিউজলেটার সাবস্ক্রাইবার তালিকা')
@section('page_title', 'নিউজলেটার গ্রাহক তালিকা')

@section('content')
    <div class="card card-outline card-info shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title font-weight-bold">মোট সাবস্ক্রাইবার: {{ $subscribers->total() }} জন</h3>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped mb-0">
                    <thead>
                        <tr>
                            <th style="width: 60px;">#</th>
                            <th>ইমেইল এড্রেস</th>
                            <th>সাবস্ক্রিপশনের সময়</th>
                            <th style="width: 100px;" class="text-right">অ্যাকশন</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($subscribers as $index => $subscriber)
                            <tr>
                                <td>{{ $subscribers->firstItem() + $index }}</td>
                                <td>
                                    <span class="font-weight-bold"><a href="mailto:{{ $subscriber->email }}">{{ $subscriber->email }}</a></span>
                                </td>
                                <td>
                                    {{ $subscriber->subscribed_at ? $subscriber->subscribed_at->format('d M, Y (h:i A)') : $subscriber->created_at->format('d M, Y') }}
                                    <small class="text-muted ml-2">({{ $subscriber->created_at->diffForHumans() }})</small>
                                </td>
                                <td class="text-right">
                                    <form action="{{ route('admin.subscribers.destroy', $subscriber) }}" method="POST" class="d-inline" onsubmit="return confirm('আপনি কি নিশ্চিত এই গ্রাহককে তালিকা থেকে মুছে ফেলতে চান?');">
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
                                <td colspan="4" class="text-center py-4 text-muted">কোনো সাবস্ক্রাইবার পাওয়া যায়নি।</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if ($subscribers->hasPages())
            <div class="card-footer clearfix">
                {{ $subscribers->links() }}
            </div>
        @endif
    </div>
@endsection
