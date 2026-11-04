@extends('layouts.app')

@section('title', $post->title)
@section('meta_description', Str::limit(strip_tags($post->excerpt ?: $post->content), 160))
@section('canonical_url', route('blog.show', $post->slug))
@if ($post->image)
    @section('og_image', str_starts_with($post->image, 'http') ? $post->image : asset($post->image))
@endif

@section('content')
    <!--============================
        BREADCRUMB START
    =============================-->
    @include('layouts.partials.breadcrumb', [
        'title' => $post->title,
        'subtitle' => 'ব্লগ ডিটেইলস'
    ])
    <!--============================
        BREADCRUMB END
    =============================-->

    <!--==============================
        BLOG DETAILS START
    ===============================-->
    <section class="blog_details pt_120 xs_pt_80 pb_120 xs_pb_80">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 wow fadeInLeft" data-wow-duration="1s">
                    <div class="blog_details_content">
                        @if ($post->image)
                            <div class="blog_details_img mb-4">
                                <img src="{{ str_starts_with($post->image, 'http') ? $post->image : asset($post->image) }}" alt="{{ $post->title }}" class="img-fluid w-100 rounded-3 shadow-sm">
                            </div>
                        @endif

                        <ul class="blog_det_header d-flex flex-wrap list-unstyled mb-3">
                            <li class="me-4"><i class="far fa-user-circle text-primary me-1"></i> {{ $post->author ?: 'এডমিন' }}</li>
                            @if ($post->published_at)
                                <li><i class="fal fa-calendar-alt text-primary me-1"></i> {{ $post->published_at->format('d M, Y') }}</li>
                            @endif
                        </ul>

                        <div class="blog_details_text">
                            <h2 class="mb-4 font-weight-bold text-dark">{{ $post->title }}</h2>
                            <div class="blog-body-content text-muted lh-lg" style="font-size: 1.05rem;">
                                {!! $post->content !!}
                            </div>
                        </div>

                        <!-- Social Share Bar -->
                        <div class="blog-details-bar mt-4 pt-4 border-top">
                            <div class="d-flex flex-wrap align-items-center justify-content-between">
                                <h5 class="title mb-2 mb-md-0 font-weight-bold"><i class="fas fa-share-alt mr-1"></i> এই পোস্টটি শেয়ার করুন:</h5>
                                <div class="d-flex gap-2">
                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" rel="noopener" class="btn btn-outline-primary btn-sm rounded-circle px-3 py-2" title="Facebook">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($post->title) }}" target="_blank" rel="noopener" class="btn btn-outline-info btn-sm rounded-circle px-3 py-2" title="Twitter">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                    <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(url()->current()) }}" target="_blank" rel="noopener" class="btn btn-outline-primary btn-sm rounded-circle px-3 py-2" title="LinkedIn">
                                        <i class="fab fa-linkedin-in"></i>
                                    </a>
                                    <a href="https://api.whatsapp.com/send?text={{ urlencode($post->title . ' ' . url()->current()) }}" target="_blank" rel="noopener" class="btn btn-outline-success btn-sm rounded-circle px-3 py-2" title="WhatsApp">
                                        <i class="fab fa-whatsapp"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Column -->
                <div class="col-lg-4 wow fadeInRight" data-wow-duration="1s">
                    <div id="sticky_sidebar" class="sidebar">
                        @if (isset($recentPosts) && $recentPosts->isNotEmpty())
                            <div class="sidebar_post card p-4 shadow-sm border-0 mb-4">
                                <h3 class="fs-5 font-weight-bold border-bottom pb-2 mb-3">নতুন ব্লগ</h3>
                                <ul class="list-unstyled mb-0">
                                    @foreach ($recentPosts as $recent)
                                        <li class="d-flex align-items-center mb-3 pb-3 border-bottom">
                                            <div class="img me-3 flex-shrink-0" style="width: 80px; height: 60px;">
                                                <a href="{{ route('blog.show', $recent->slug) }}">
                                                    <img src="{{ $recent->image ? (str_starts_with($recent->image, 'http') ? $recent->image : asset($recent->image)) : asset('assets/front/img/blog/17369712521247617361.png') }}" alt="{{ $recent->title }}" class="img-fluid rounded" style="width: 80px; height: 60px; object-fit: cover;">
                                                </a>
                                            </div>
                                            <div class="text">
                                                @if ($recent->published_at)
                                                    <small class="text-muted d-block"><i class="fal fa-calendar-alt me-1"></i> {{ $recent->published_at->format('d M, Y') }}</small>
                                                @endif
                                                <a href="{{ route('blog.show', $recent->slug) }}" class="text-dark fw-bold text-decoration-none">
                                                    {{ Str::limit($recent->title, 42) }}
                                                </a>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- CTA Card -->
                        <div class="card p-4 shadow-sm border-0 bg-primary text-white text-center rounded-3">
                            <h4 class="font-weight-bold mb-2">আপনার প্রজেক্ট শুরু করতে চান?</h4>
                            <p class="small mb-3 text-white-50">আমাদের বিশেষজ্ঞ টিমের সাথে যোগাযোগ করুন অথবা ফ্রি কনসালটেশন রিকোয়েস্ট করুন।</p>
                            <a href="{{ route('quote') }}" class="btn btn-light font-weight-bold py-2">
                                ফ্রি কনসালটেশন নিন
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--==============================
        BLOG DETAILS END
    ===============================-->
@endsection
