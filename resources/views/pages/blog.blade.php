@extends('layouts.app')

@section('title', 'ব্লগ ও খবর')

@section('content')
    @include('layouts.partials.breadcrumb', ['title' => 'ব্লগ ও খবর', 'subtitle' => 'ব্লগ'])

    <!--============================
        BLOG START (DYNAMIC)
    =============================-->
    <section class="blog pt_115 xs_pt_75 pb_115 xs_pb_75">
        <div class="container">
            <div class="row">
                @forelse ($posts as $post)
                    <div class="col-xl-4 col-md-6 col-lg-4 wow fadeInUp mb-4" data-wow-duration="1s">
                        <div class="single_blog h-100 d-flex flex-column justify-content-between">
                            <div>
                                <div class="single_blog_img">
                                    <a href="{{ route('blog.show', $post->slug) }}" style="position: static; padding: 0; background: transparent; border-radius: 0; display: block;">
                                        <img src="{{ $post->image ? (str_starts_with($post->image, 'http') ? $post->image : asset($post->image)) : asset('assets/front/img/blog/17369699791678462702.png') }}" alt="{{ $post->title }}" class="img-fluid w-100">
                                    </a>
                                </div>
                                <div class="single_blog_text">
                                    <ul>
                                        <li><i class="far fa-user-circle"></i> {{ $post->author }}</li>
                                        <li><i class="fal fa-calendar-alt"></i> {{ $post->published_at ? $post->published_at->format('d M, Y') : '' }}</li>
                                    </ul>
                                    <a class="title" href="{{ route('blog.show', $post->slug) }}">
                                        {{ $post->title }}
                                    </a>
                                    <p>{{ Str::limit($post->excerpt ?: $post->content, 120) }}</p>
                                </div>
                            </div>
                            <div class="p-3">
                                <a class="more_btn" href="{{ route('blog.show', $post->slug) }}">
                                    বিস্তারিত পড়ুন <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <p class="text-muted fs-5">বর্তমানে কোনো ব্লগ পোস্ট নেই।</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if ($posts->hasPages())
                <div class="row mt-4">
                    <div class="col-12 d-flex justify-content-center">
                        {{ $posts->links() }}
                    </div>
                </div>
            @endif
        </div>
    </section>
    <!--============================
        BLOG END
    =============================-->
@endsection
