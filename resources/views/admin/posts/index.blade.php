@extends('admin.layouts.app')

@section('title', 'ব্লগ পোস্ট তালিকা')
@section('page_title', 'ব্লগ পোস্ট ম্যানেজমেন্ট')

@section('content')
    <div class="card card-outline card-warning shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title font-weight-bold">সকল ব্লগ পোস্ট</h3>
            <a href="{{ route('admin.posts.create') }}" class="btn btn-warning btn-sm">
                <i class="fas fa-plus-circle mr-1"></i> নতুন পোস্ট লিখুন
            </a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped mb-0">
                    <thead>
                        <tr>
                            <th style="width: 80px;">ছবি</th>
                            <th>শিরোনাম</th>
                            <th>লেখক</th>
                            <th>প্রকাশের তারিখ</th>
                            <th>স্ট্যাটাস</th>
                            <th style="width: 150px;" class="text-right">অ্যাকশন</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($posts as $post)
                            <tr>
                                <td>
                                    <img src="{{ $post->image ? asset($post->image) : asset('assets/front/img/blog/17369699791678462702.png') }}" alt="{{ $post->title }}" class="img-thumbnail" style="width: 60px; height: 45px; object-fit: cover;">
                                </td>
                                <td>
                                    <div class="font-weight-bold">{{ $post->title }}</div>
                                    <small class="text-muted">{{ Str::limit($post->excerpt ?: $post->content, 80) }}</small>
                                </td>
                                <td>{{ $post->author }}</td>
                                <td>{{ $post->published_at ? $post->published_at->format('d M, Y') : 'খসড়া' }}</td>
                                <td>
                                    @if ($post->is_published)
                                        <span class="badge badge-success">প্রকাশিত</span>
                                    @else
                                        <span class="badge badge-secondary">খসড়া</span>
                                    @endif
                                </td>
                                <td class="text-right">
                                    <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-sm btn-info mr-1">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" class="d-inline" onsubmit="return confirm('আপনি কি নিশ্চিত এই পোস্টটি মুছে ফেলতে চান?');">
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
                                <td colspan="6" class="text-center py-4 text-muted">কোনো ব্লগ পোস্ট পাওয়া যায়নি।</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if ($posts->hasPages())
            <div class="card-footer clearfix">
                {{ $posts->links() }}
            </div>
        @endif
    </div>
@endsection
