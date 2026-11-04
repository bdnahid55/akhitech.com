@extends('layouts.app')

@section('title', 'আমাদের সম্পর্কে')

@section('content')
    @include('layouts.partials.breadcrumb', ['title' => 'আমাদের সম্পর্কে', 'subtitle' => 'পরিচিতি'])

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
                                <span><i class="fas fa-award fa-2x text-white"></i></span>
                                <h3>{{ $siteSettings['about_support_title'] ?? '২৪/৭ সাপোর্ট' }}</h3>
                                <p>{{ $siteSettings['about_support_text'] ?? 'আমাদের নিবেদিত টিম সার্বক্ষণিক প্রস্তুত' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 wow fadeInRight" data-wow-duration="1s">
                    <div class="section_heading pt_35">
                        <h3>{{ $siteSettings['about_subtitle'] ?? 'কোম্পানি পরিচিতি' }}</h3>
                        <h2>{{ $siteSettings['about_title'] ?? 'আমাদের রয়েছে ৬ বছরের বাস্তব অভিজ্ঞতা' }}</h2>
                    </div>
                    <div class="about_content">
                        <p>
                            {{ $siteSettings['about_description'] ?? (($siteSettings['site_name'] ?? config('app.name', 'Akhitech')) . ' একটি আধুনিক ও নির্ভরযোগ্য সফটওয়্যার ও আইটি প্রতিষ্ঠান। আমরা ক্ষুদ্র ও মাঝারি ব্যবসা থেকে শুরু করে বৃহৎ করপোরেট প্রতিষ্ঠানগুলোর জন্য কাস্টম ওয়েব ও সফটওয়্যার সল্যুশন তৈরি করি।') }}
                        </p>
                        <div class="grid_item">
                            <div class="left">
                                @if (!empty($siteSettings['about_experience_text']))
                                    <div class="experience">
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
                                <a class="common_btn" href="{{ route('quote') }}">ফ্রি কনসালটেশন</a>
                            </div>
                            <div class="right">
                                <div class="counter_item">
                                    <h4>{{ $siteSettings['about_counter_1_number'] ?? '১০০%' }}</h4>
                                    <p>{{ $siteSettings['about_counter_1_title'] ?? 'সফলতার হার' }}</p>
                                </div>
                                <hr>
                                <div class="counter_item">
                                    <h4>{{ $siteSettings['about_counter_2_number'] ?? '৪৬৫+' }}</h4>
                                    <p>{{ $siteSettings['about_counter_2_title'] ?? 'সন্তুষ্ট গ্রাহক' }}</p>
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
        ACHIEVEMENTS START (DYNAMIC)
    ===============================-->
    <section class="achievements pt_115 xs_mt_75 pb_115 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-xl-8 m-auto">
                    <div class="section_heading text-center">
                        <h3>{{ $siteSettings['achievement_subtitle'] ?? 'আমাদের সাফল্য' }}</h3>
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
        TEAM START
    ===============================-->
    <section class="team pt_115 xs_pt_75 pb_120 xs_pb_80">
        <div class="container">
            <div class="row">
                <div class="col-xl-8">
                    <div class="section_heading pb_20">
                        <h3>{{ $siteSettings['team_subtitle'] ?? 'আমাদের টিম' }}</h3>
                        <h2>{{ $siteSettings['team_title'] ?? 'আমাদের সকল টিম মেম্বাদেরকে দেখুন' }}</h2>
                    </div>
                </div>
            </div>
            <div class="row team_slider">
                @forelse ($teamMembers as $member)
                    <div class="col-xl-3 wow fadeInUp" data-wow-duration="1s">
                        <div class="single_team">
                            <img src="{{ $member->image ? asset($member->image) : asset('assets/front/img/team/17384272841396583989.png') }}" alt="{{ $member->name }}" class="img-fluid w-100">
                            <div class="text">
                                <a href="javascript:void(0)">{{ $member->name }}</a>
                                <p>{{ $member->designation }}</p>
                            </div>
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
@endsection
