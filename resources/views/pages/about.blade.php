@extends('layouts.app')

@section('title', 'আমাদের সম্পর্কে')

@section('content')
    @include('layouts.partials.breadcrumb', ['title' => 'আমাদের সম্পর্কে', 'subtitle' => 'পরিচিতি'])

    <!--==============================
        ABOUT START
    ===============================-->
    <section class="about pt_120 xs_pt_80 pb_120 xs_pb_80">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 wow fadeInLeft" data-wow-duration="1s">
                    <div class="about_img_box">
                        <div class="small_img">
                            <img src="{{ asset('assets/front/img/1736010555348706608.png') }}" alt="about" class="img-fluid w-100">
                        </div>
                        <div class="main_img">
                            <img src="{{ asset('assets/front/img/1736010571398020711.png') }}" alt="about" class="img-fluid w-100">
                        </div>
                        <div class="support_img">
                            <img src="{{ asset('assets/front/img/17361016132036935658.png') }}" alt="about" class="img-fluid w-100">
                            <div class="item_card">
                                <span><i class="fas fa-award fa-2x text-white"></i></span>
                                <h3>২৪/৭ সাপোর্ট</h3>
                                <p>আমাদের নিবেদিত টিম সার্বক্ষণিক প্রস্তুত</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 wow fadeInRight" data-wow-duration="1s">
                    <div class="section_heading pt_35">
                        <h3>কোম্পানি পরিচিতি</h3>
                        <h2>আমাদের রয়েছে ৬ বছরের বাস্তব অভিজ্ঞতা</h2>
                    </div>
                    <div class="about_content">
                        <p>
                            {{ $siteSettings['site_name'] ?? config('app.name', 'Akhitech') }} একটি আধুনিক ও নির্ভরযোগ্য সফটওয়্যার ও আইটি প্রতিষ্ঠান। আমরা ক্ষুদ্র ও মাঝারি ব্যবসা থেকে শুরু করে বৃহৎ করপোরেট প্রতিষ্ঠানগুলোর জন্য কাস্টম ওয়েব ও সফটওয়্যার সল্যুশন তৈরি করি।
                        </p>
                        <div class="grid_item">
                            <div class="left">
                                <div class="experience">
                                    <p>৬ বছরের পেশাদার <span>অভিজ্ঞতা</span></p>
                                </div>
                                <ul>
                                    <li>ওয়েব ডিজাইন ও ডেভেলপমেন্ট</li>
                                    <li>সফটওয়্যার ডেভেলপমেন্ট</li>
                                    <li>গ্রাফিক্স ও UI/UX ডিজাইন</li>
                                    <li>সার্চ ইঞ্জিন অপটিমাইজেশন (SEO)</li>
                                </ul>
                                <a class="common_btn" href="{{ route('quote') }}">ফ্রি কনসালটেশন</a>
                            </div>
                            <div class="right">
                                <div class="counter_item">
                                    <h4>১০০%</h4>
                                    <p>সফলতার হার</p>
                                </div>
                                <hr>
                                <div class="counter_item">
                                    <h4>৪৬৫+</h4>
                                    <p>সন্তুষ্ট গ্রাহক</p>
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
        ACHIEVEMENTS START
    ===============================-->
    <section class="achievements pt_115 xs_mt_75 pb_115 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-xl-8 m-auto">
                    <div class="section_heading text-center">
                        <h3>আমাদের সাফল্য</h3>
                        <h2>আমাদের অর্জন সমূহ</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-duration="1s">
                    <div class="achievement_item">
                        <h4><span class="counter">৫৬৮</span>+</h4>
                        <p>কমপ্লিট প্রজেক্ট</p>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-duration="1s">
                    <div class="achievement_item">
                        <h4><span class="counter">৪৫৬</span>+</h4>
                        <p>সন্তুষ্ট ক্লায়েন্ট</p>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-duration="1s">
                    <div class="achievement_item">
                        <h4><span class="counter">২৫৬</span>+</h4>
                        <p>গ্রোইং বিজনেস</p>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-duration="1s">
                    <div class="achievement_item">
                        <h4><span class="counter">২৪</span>/৭</h4>
                        <p>সাপোর্ট টিম</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--==============================
        ACHIEVEMENTS END
    ===============================-->
@endsection
