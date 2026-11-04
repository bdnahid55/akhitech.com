@extends('layouts.app')

@section('title', 'প্রোজেক্ট সমূহ')

@section('content')
    @include('layouts.partials.breadcrumb', ['title' => 'আমাদের প্রোজেক্ট সমূহ', 'subtitle' => 'পোর্টফোলিও'])

    <!--==============================
        PROJECTS PAGE START (DYNAMIC)
    ===============================-->
    <section class="projects_page pt_95 xs_pt_55 pb_120 xs_pb_80">
        <div class="container">
            <div class="row">
                @forelse ($portfolios as $portfolio)
                    <div class="col-xl-4 col-sm-6 col-lg-4 wow fadeInUp mb-4" data-wow-duration="1s">
                        <div class="project_item">
                            <a href="{{ route('portfolio.show', $portfolio->slug) }}">
                                <img src="{{ $portfolio->image ? asset($portfolio->image) : asset('assets/front/img/portfolio/1736978150325788965.png') }}" alt="{{ $portfolio->title }}" class="img-fluid w-100">
                            </a>
                            <div class="project_item_text">
                                <span>{{ $portfolio->category }}</span>
                                <h3><a href="{{ route('portfolio.show', $portfolio->slug) }}" class="text-white">{{ $portfolio->title }}</a></h3>
                                <a href="{{ route('portfolio.show', $portfolio->slug) }}">
                                    বিস্তারিত জানুন <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <p class="text-muted fs-5">বর্তমানে কোনো পোর্টফোলিও প্রজেক্ট নেই।</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
    <!--==============================
        PROJECTS PAGE END
    ===============================-->
@endsection
