@extends('layouts.app')

@section('title', $portfolio->title)
@section('meta_description', Str::limit(strip_tags($portfolio->description), 160))
@section('canonical_url', route('portfolio.show', $portfolio->slug))
@if ($portfolio->image)
    @section('og_image', str_starts_with($portfolio->image, 'http') ? $portfolio->image : asset($portfolio->image))
@endif

@section('content')
    <!--============================
        BREADCRUMB START
    =============================-->
    @include('layouts.partials.breadcrumb', [
        'title' => $portfolio->title,
        'subtitle' => 'প্রোজেক্ট'
    ])
    <!--============================
        BREADCRUMB END
    =============================-->

    <!--==============================
        PROJECTS DETAILS START
    ===============================-->
    <section class="projects_details pt_120 xs_pt_80 pb_110 xs_pb_70">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 wow fadeInLeft" data-wow-duration="1s">
                    <div class="projects_details_contect">
                        @if ($portfolio->image)
                            <div class="projects_details_img mb-4">
                                <img src="{{ str_starts_with($portfolio->image, 'http') ? $portfolio->image : asset($portfolio->image) }}" alt="{{ $portfolio->title }}" class="img-fluid w-100 rounded-3 shadow-sm">
                            </div>
                        @endif

                        <div class="projects_details_text">
                            <h2 class="mb-3 font-weight-bold">{{ $portfolio->title }}</h2>
                            <div class="project-body-content text-muted lh-lg">
                                {!! $portfolio->description !!}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 wow fadeInRight" data-wow-duration="1s">
                    <div id="sticky_sidebar" class="sidebar">
                        <div class="sidebar_project_info">
                            <h2>প্রোজেক্ট এর তথ্য</h2>
                            <ul class="list">
                                @if ($portfolio->start_date)
                                    <li><span>শুরুর তারিখ :</span> {{ $portfolio->start_date }}</li>
                                @endif
                                @if ($portfolio->end_date)
                                    <li><span>সাবমিট এর তারিখ :</span> {{ $portfolio->end_date }}</li>
                                @endif
                                @if ($portfolio->client_name)
                                    <li><span>ক্লাইন্টের নাম :</span> {{ $portfolio->client_name }}</li>
                                @endif
                                <li><span>ক্যাটাগরি :</span> {{ $portfolio->category }}</li>
                                @if ($portfolio->project_url)
                                    <li>
                                        <span>লাইভ প্রিভিউ :</span>
                                        <a href="{{ $portfolio->project_url }}" target="_blank" rel="noopener">
                                            {{ Str::limit($portfolio->project_url, 30) }}
                                        </a>
                                    </li>
                                @endif
                            </ul>

                            @if ($portfolio->project_url)
                                <div class="mt-4 pt-2">
                                    <a href="{{ $portfolio->project_url }}" target="_blank" rel="noopener" class="common_btn w-100 text-center">
                                        লাইভ সাইট দেখুন <i class="fas fa-external-link-alt ms-1"></i>
                                    </a>
                                </div>
                            @endif

                            <div class="mt-3">
                                <a href="{{ route('quote') }}" class="btn btn-outline-primary w-100 py-2 font-weight-bold">
                                    অনুরূপ প্রজেক্টের জন্য কোটেশন নিন
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--==============================
        PROJECTS DETAILS END
    ===============================-->

    <!--==============================
        RELATED PROJECTS START
    ===============================-->
    @if(isset($relatedPortfolios) && $relatedPortfolios->isNotEmpty())
        <section class="projects related_project pb_110 xs_pb_70">
            <div class="container">
                <div class="section_heading mb-4">
                    <h3>পোর্টফোলিও</h3>
                    <h2>সম্পর্কিত প্রোজেক্ট সমূহ</h2>
                </div>
                <div class="row">
                    @foreach($relatedPortfolios as $related)
                        <div class="col-xl-4 col-md-6 col-lg-4 wow fadeInUp mb-4" data-wow-duration="1s">
                            <div class="project_item">
                                <img src="{{ $related->image ? (str_starts_with($related->image, 'http') ? $related->image : asset($related->image)) : asset('assets/front/img/portfolio/1736978150325788965.png') }}" alt="{{ $related->title }}" class="img-fluid w-100">
                                <div class="project_item_text">
                                    <span>{{ $related->category }}</span>
                                    <h3>{{ $related->title }}</h3>
                                    <a href="{{ route('portfolio.show', $related->slug) }}">
                                        বিস্তারিত জানুন <i class="fas fa-arrow-right ms-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
    <!--==============================
        RELATED PROJECTS END
    ===============================-->
@endsection
