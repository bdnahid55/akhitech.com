@extends('layouts.app')

@section('title', 'হোম')

@section('content')
    @php
        $bannerBg = !empty($siteSettings['banner_bg_image']) ? (str_starts_with($siteSettings['banner_bg_image'], 'http') ? $siteSettings['banner_bg_image'] : asset($siteSettings['banner_bg_image'])) : asset('assets/front/img/17361026461740401592.jpg');
        $bannerImg = !empty($siteSettings['banner_image']) ? (str_starts_with($siteSettings['banner_image'], 'http') ? $siteSettings['banner_image'] : asset($siteSettings['banner_image'])) : asset('assets/front/img/17361014651911523454.png');
    @endphp
    <!--==============================
        BANNER START (DYNAMIC)
    ===============================-->
    <section class="banner" style="background: url({{ $bannerBg }}) no-repeat center/cover;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xl-6 col-lg-6 wow fadeInLeft" data-wow-duration="1s">
                    <div class="banner_content">
                        @if (!empty($siteSettings['banner_subtitle']))
                            <h3>{{ $siteSettings['banner_subtitle'] }}</h3>
                        @endif
                        <h1>{{ $siteSettings['banner_title'] ?? 'Creating New Ideas for Your Business' }}</h1>
                        <p class="description">
                            {{ $siteSettings['banner_description'] ?? 'আমাদের কাছ থেকে মাত্র ৮০০০ টাকা দিয়ে আপনার স্বপ্নের ওয়েবসাইট ও সফটওয়্যার তৈরি করুন। আপনার ওয়েবসাইট হবে ১০০% রেসপনসিভ, দ্রুতগতির ও নিরাপদ।' }}
                        </p>
                        <div class="banner_btn d-flex flex-wrap align-items-center">
                            <a href="{{ $siteSettings['banner_btn_url'] ?? route('quote') }}" class="common_btn">
                                {{ $siteSettings['banner_btn_text'] ?? 'ফ্রি কনসালটেশন' }}
                            </a>
                            @if (!empty($siteSettings['banner_video_url']) && $siteSettings['banner_video_url'] !== '#')
                                <a class="venobox play_btn ms-3" data-autoplay="true" data-vbtype="video" href="{{ $siteSettings['banner_video_url'] }}" aria-label="Play video">
                                    <i class="fas fa-play"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 wow fadeInRight" data-wow-duration="1s">
                    <div class="banner_img">
                        <img src="{{ $bannerImg }}" alt="{{ $siteSettings['banner_title'] ?? 'banner-img' }}" class="img-fluid w-100">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--==============================
        BANNER END
    ===============================-->

    @php
        $aboutMainImg = !empty($siteSettings['about_main_image']) ? (str_starts_with($siteSettings['about_main_image'], 'http') ? $siteSettings['about_main_image'] : asset($siteSettings['about_main_image'])) : asset('assets/front/img/1736010571398020711.png');
        $aboutSmallImg = !empty($siteSettings['about_small_image']) ? (str_starts_with($siteSettings['about_small_image'], 'http') ? $siteSettings['about_small_image'] : asset($siteSettings['about_small_image'])) : asset('assets/front/img/1736010555348706608.png');
        $aboutSupportImg = !empty($siteSettings['about_support_image']) ? (str_starts_with($siteSettings['about_support_image'], 'http') ? $siteSettings['about_support_image'] : asset($siteSettings['about_support_image'])) : asset('assets/front/img/17361016132036935658.png');
    @endphp
    <!--==============================
        ABOUT START (DYNAMIC)
    ===============================-->
    <section class="about pt_120 xs_pt_80 pb_120 xs_pb_80">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 wow fadeInLeft" data-wow-duration="1s">
                    <div class="about_img_box">
                        <div class="small_img">
                            <img src="{{ $aboutSmallImg }}" alt="about" class="img-fluid w-100">
                        </div>
                        <div class="main_img">
                            <img src="{{ $aboutMainImg }}" alt="about" class="img-fluid w-100">
                        </div>
                        <div class="support_img">
                            <img src="{{ $aboutSupportImg }}" alt="about" class="img-fluid w-100">
                            <div class="item_card">
                                <span><i class="fas fa-headset fa-2x text-white"></i></span>
                                <h3>{{ $siteSettings['about_support_title'] ?? '২৪/৭ সাপোর্ট' }}</h3>
                                <p>{{ $siteSettings['about_support_text'] ?? 'যেকোন সময়ে, যেকোন সমস্যায়' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 wow fadeInRight" data-wow-duration="1s">
                    <div class="section_heading pt_35">
                        <h3>{{ $siteSettings['about_subtitle'] ?? 'কোম্পানি সম্পর্কে' }}</h3>
                        <h2>{{ $siteSettings['about_title'] ?? 'আমাদের রয়েছে ৬ বছরের পেশাদার অভিজ্ঞতা' }}</h2>
                    </div>
                    <div class="about_content">
                        <p>
                            {!! nl2br(e($siteSettings['about_description'] ?? (($siteSettings['site_name'] ?? config('app.name', 'Akhitech')) . ' হচ্ছে বাংলাদেশের অন্যতম বিশ্বস্ত ডিজিটাল সল্যুশন, সফটওয়্যার ডেভেলপমেন্ট ও ওয়েবসাইট মেইনটেনেন্স এজেন্সি। সাশ্রয়ী মূল্যে সর্বোচ্চ কোয়ালিটির আইটি সেবা প্রদান করাই আমাদের মূল লক্ষ্য।'))) !!}
                        </p>
                        <div class="grid_item">
                            <div class="left">
                                @if (!empty($siteSettings['about_experience_text']))
                                    <div class="experience">
                                        <span>
                                            <i class="fas fa-award text-danger fa-lg"></i>
                                        </span>
                                        <p>{{ $siteSettings['about_experience_text'] }}</p>
                                    </div>
                                @endif
                                <ul>
                                    @if (!empty($siteSettings['about_feature_1']))
                                        <li>{{ $siteSettings['about_feature_1'] }}</li>
                                    @endif
                                    @if (!empty($siteSettings['about_feature_2']))
                                        <li>{{ $siteSettings['about_feature_2'] }}</li>
                                    @endif
                                    @if (!empty($siteSettings['about_feature_3']))
                                        <li>{{ $siteSettings['about_feature_3'] }}</li>
                                    @endif
                                    @if (!empty($siteSettings['about_feature_4']))
                                        <li>{{ $siteSettings['about_feature_4'] }}</li>
                                    @endif
                                </ul>
                                <a class="common_btn" href="{{ route('about') }}">আরও জানুন</a>
                            </div>
                            <div class="right">
                                <div class="counter_item">
                                    <h4>{{ $siteSettings['about_counter_1_number'] ?? '১০০%' }}</h4>
                                    <p>{{ $siteSettings['about_counter_1_title'] ?? 'সফলতার রেট' }}</p>
                                </div>
                                <hr>
                                <div class="counter_item">
                                    <h4>{{ $siteSettings['about_counter_2_number'] ?? '৪৬৫+' }}</h4>
                                    <p>{{ $siteSettings['about_counter_2_title'] ?? 'সন্তুষ্ট ক্লায়েন্ট' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--==============================
        ABOUT END
    ===============================-->

    <!--==============================
        SERVICES START (DYNAMIC)
    ===============================-->
    <section class="services pt_115 xs_pt_75 pb_95 xs_pb_55 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-xl-8 m-auto">
                    <div class="section_heading text-center">
                        <h3>আমাদের সার্ভিস সমূহ</h3>
                        <h2>উচ্চ মানের ডিজিটাল সেবা</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                @forelse ($services as $service)
                    <div class="col-xl-3 col-md-6 col-lg-4 wow fadeInUp" data-wow-duration="1s">
                        <div class="service_item">
                            <span class="icon"><i class="{{ $service->icon ?: 'fas fa-laptop-code' }}"></i></span>
                            <h2>{{ $service->title }}</h2>
                            <p>{{ $service->short_description }}</p>
                            <a href="{{ route('services') }}">বিস্তারিত</a>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-4">
                        <p class="text-muted">বর্তমানে কোনো সার্ভিস পাওয়া যায়নি।</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
    <!--==============================
        SERVICES END
    ===============================-->

    <!--==============================
        ACHIEVEMENTS START (DYNAMIC)
    ===============================-->
    <section class="achievements pt_115 xs_mt_75">
        <div class="container">
            <div class="row">
                <div class="col-xl-8 m-auto">
                    <div class="section_heading text-center">
                        <h3>{{ $siteSettings['achievement_subtitle'] ?? 'অর্জন সমূহ' }}</h3>
                        <h2>{{ $siteSettings['achievement_title'] ?? 'আমাদের অর্জন সমূহ' }}</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                @forelse ($achievements as $achievement)
                    <div class="col-lg-3 col-sm-6 wow fadeInUp mb-4 mb-lg-0" data-wow-duration="1s">
                        <div class="achievement_item">
                            <div class="icon">
                                @if ($achievement->image)
                                    <span><img src="{{ asset($achievement->image) }}" alt="{{ $achievement->title }}" class="img-fluid" style="max-height: 40px;"></span>
                                @elseif ($achievement->icon)
                                    <i class="{{ $achievement->icon }} fa-2x text-white"></i>
                                @else
                                    <i class="fas fa-trophy fa-2x text-white"></i>
                                @endif
                            </div>
                            <h4><span class="counter">{{ $achievement->count }}</span>{{ $achievement->suffix ?? '+' }}</h4>
                            <p>{{ $achievement->title }}</p>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-4">
                        <p class="text-muted">কোনো অর্জনের তথ্য পাওয়া যায়নি।</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
    <!--==============================
        ACHIEVEMENTS END
    ===============================-->

    <!--==============================
        PORTFOLIO START (DYNAMIC)
    ===============================-->
    <section class="projects pt_115 xs_pt_75 pb_120 xs_pb_80">
        <div class="container">
            <div class="row">
                <div class="col-xl-8 m-auto">
                    <div class="section_heading text-center">
                        <h3>পোর্টফোলিও</h3>
                        <h2>আমাদের সফল প্রজেক্ট সমূহ</h2>
                    </div>
                </div>
            </div>
            <div class="row grid">
                @forelse ($portfolios as $portfolio)
                    <div class="col-xl-4 col-sm-6 col-lg-4 wow fadeInUp" data-wow-duration="1s">
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
                    <div class="col-12 text-center py-4">
                        <p class="text-muted">বর্তমানে কোনো প্রজেক্ট পাওয়া যায়নি।</p>
                    </div>
                @endforelse
            </div>
            <div class="text-center mt-4">
                <a href="{{ route('portfolio') }}" class="common_btn">সব প্রজেক্ট দেখুন</a>
            </div>
        </div>
    </section>
    <!--==============================
        PORTFOLIO END
    ===============================-->

    <!--==============================
        TEAM START
    ===============================-->
    <section class="home_2_team pt_115 xs_pt_75 pb_120 xs_pb_80">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="section_heading pb_20">
                        <h3>{{ $siteSettings['team_subtitle'] ?? 'আমাদের টিম' }}</h3>
                        <h2>{{ $siteSettings['team_title'] ?? 'আমাদের সকল টিম মেম্বাদেরকে দেখুন' }}</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                @forelse ($teamMembers as $member)
                    <div class="col-xl-3 col-sm-6 col-lg-4 wow fadeInUp" data-wow-duration="1s">
                        <div class="home_2_team_item">
                            <div class="image">
                                <span>
                                    <img src="{{ $member->image ? asset($member->image) : asset('assets/front/img/team/17384272841396583989.png') }}" alt="{{ $member->name }}" class="img-fluid w-100">
                                </span>
                            </div>
                            <div class="text">
                                <ul>
                                    @if ($member->facebook)
                                        <li><a href="{{ $member->facebook }}" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                                    @endif
                                    @if ($member->twitter)
                                        <li><a href="{{ $member->twitter }}" target="_blank"><i class="fab fa-twitter"></i></a></li>
                                    @endif
                                    @if ($member->behance)
                                        <li><a href="{{ $member->behance }}" target="_blank"><i class="fab fa-behance"></i></a></li>
                                    @endif
                                    @if ($member->linkedin)
                                        <li><a href="{{ $member->linkedin }}" target="_blank"><i class="fab fa-linkedin-in"></i></a></li>
                                    @endif
                                </ul>
                                <a class="link" href="javascript:void(0)">{{ $member->name }}</a>
                                <p>{{ $member->designation }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-4">
                        <p class="text-muted">কোনো টিম মেম্বার পাওয়া যায়নি।</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
    <!--==============================
        TEAM END
    ===============================-->

    <!--==============================
        TESTIMONIAL START
    ===============================-->
    <section class="home_2_testimonial pt_115 xs_pt_75 pb_120 xs_pb_80" style="background: url({{ asset('assets/frontend/images/testimonial_2_bg.png') }});">
        <div class="container">
            <div class="row">
                <div class="col-xl-8 m-auto">
                    <div class="section_heading text-center">
                        <h3>{{ $siteSettings['testimonial_subtitle'] ?? 'প্রশংসা সমূহ' }}</h3>
                        <h2>{{ $siteSettings['testimonial_title'] ?? 'আমাদের ক্লায়েন্টগন কি বলে' }}</h2>
                    </div>
                </div>
            </div>
            <div class="row home_2_team_slider">
                @forelse($testimonials as $testimonial)
                    <div class="col-lg-4 wow fadeInUp" data-wow-duration="1s">
                        <div class="home_2_single_team">
                            <span>
                                <img src="{{ $testimonial->image ? asset($testimonial->image) : asset('assets/front/img/17362348801814731466.png') }}" alt="{{ $testimonial->name }}" class="img-fluid w-100">
                            </span>
                            <p>{{ $testimonial->comment }}</p>
                            <div class="item_bottom">
                                <div class="text">
                                    <h4>{{ $testimonial->name }}</h4>
                                    @if($testimonial->designation)
                                        <p>{{ $testimonial->designation }}</p>
                                    @endif
                                </div>
                                <ul class="d-flex text-warning">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= ($testimonial->rating ?? 5))
                                            <li><i class="fas fa-star"></i></li>
                                        @else
                                            <li><i class="far fa-star"></i></li>
                                        @endif
                                    @endfor
                                </ul>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-4">
                        <p class="text-muted">কোনো প্রশংসাপত্র পাওয়া যায়নি।</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
    <!--==============================
        TESTIMONIAL END
    ===============================-->

    <!--==============================
        BLOG START (DYNAMIC)
    ===============================-->
    <section class="blog pt_115 xs_pt_75 pb_115 xs_pb_75">
        <div class="container">
            <div class="row">
                <div class="col-xl-8 m-auto">
                    <div class="section_heading text-center pb_20">
                        <h3>লেটেস্ট খবর</h3>
                        <h2>আমাদের ব্লগ সমূহ</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                @forelse ($posts as $post)
                    <div class="col-xl-4 col-md-6 col-lg-4 wow fadeInUp" data-wow-duration="1s">
                        <div class="single_blog">
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
                                <a class="title" href="{{ route('blog.show', $post->slug) }}">{{ Str::limit($post->title, 45) }}</a>
                                <p>{{ Str::limit($post->excerpt ?: $post->content, 90) }}</p>
                                <a class="more_btn" href="{{ route('blog.show', $post->slug) }}">
                                    বিস্তারিত পড়ুন <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-4">
                        <p class="text-muted">কোনো ব্লগ পোস্ট পাওয়া যায়নি।</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
    <!--==============================
        BLOG END
    ===============================-->

    <!--==============================
        BRAND TICKER START
    ===============================-->
    <section class="brand pb_120 xs_pb_80 pt_60">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="marquee_animi">
                        <ul class="brand_logo_area d-flex flex-wrap justify-content-between align-items-center">
                            <li><img src="{{ asset('assets/front/img/client/portfolio_1736195525489339191.png') }}" alt="brand" class="img-fluid"></li>
                            <li><img src="{{ asset('assets/front/img/client/portfolio_173619566279006640.png') }}" alt="brand" class="img-fluid"></li>
                            <li><img src="{{ asset('assets/front/img/client/portfolio_17361957501573800526.png') }}" alt="brand" class="img-fluid"></li>
                            <li><img src="{{ asset('assets/front/img/client/portfolio_17361958661476768447.png') }}" alt="brand" class="img-fluid"></li>
                            <li><img src="{{ asset('assets/front/img/client/portfolio_17361960132063878358.png') }}" alt="brand" class="img-fluid"></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--==============================
        BRAND TICKER END
    ===============================-->
@endsection
