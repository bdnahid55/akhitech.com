@extends('layouts.app')

@section('title', 'ফ্রি কনসালটেশন ও কোটেশন')

@section('content')
    @include('layouts.partials.breadcrumb', ['title' => 'ফ্রি কনসালটেশন ও কোটেশন', 'subtitle' => 'কোটেশন'])

    <!--=============================
        QUOTE PAGE START
    ==============================-->
    <section class="contact mt_120 xs_mt_80 mb_120 xs_pb_80 pb_120">
        <div class="container">
            <div class="contact_form_area">
                <div class="row">
                    <div class="col-xl-5 col-lg-5 wow fadeInUp" data-wow-duration="1s">
                        <div class="contact_info_area">
                            <div class="contact_info">
                                <h3>মোবাইল নাম্বার</h3>
                                <p><a href="tel:{{ $siteSettings['contact_phone'] ?? '+8801849832178' }}">{{ $siteSettings['contact_phone'] ?? '+8801849832178' }}</a></p>
                            </div>
                            <div class="contact_info">
                                <h3>ইমেইল</h3>
                                <p><a href="mailto:{{ $siteSettings['contact_email'] ?? 'info@akhitech.com' }}">{{ $siteSettings['contact_email'] ?? 'info@akhitech.com' }}</a></p>
                            </div>
                            <div class="contact_info border-0 p-0 m-0">
                                <h3>অফিসের ঠিকানা</h3>
                                <p>{{ $siteSettings['contact_address'] ?? 'হাউজ: মুন্সি বাড়ি, নয়ার হাট স্কুল সংলগ্ন, বড়বাড়ি, লালমনিরহাট, বাংলাদেশ।' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-7 col-lg-7 wow fadeInUp" data-wow-duration="1s">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                                <strong>ধন্যবাদ!</strong> {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <form class="contact_form" action="{{ route('quote.submit') }}" method="POST">
                            @csrf
                            <h3>ফ্রি কনসালটেশন এর জন্য নিচের ফরম পূরণ করুন</h3>
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="contact_form_input">
                                        <span><i class="fas fa-user"></i></span>
                                        <input type="text" name="name" placeholder="আপনার নাম" value="{{ old('name') }}" required>
                                    </div>
                                    @error('name')
                                        <small class="text-danger d-block mt-1">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-xl-6">
                                    <div class="contact_form_input">
                                        <span><i class="fas fa-envelope"></i></span>
                                        <input type="email" name="email" placeholder="আপনার ইমেইল" value="{{ old('email') }}" required>
                                    </div>
                                    @error('email')
                                        <small class="text-danger d-block mt-1">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-xl-6">
                                    <div class="contact_form_input">
                                        <span><i class="fas fa-phone-alt"></i></span>
                                        <input type="text" name="phone" placeholder="মোবাইল নাম্বার" value="{{ old('phone') }}">
                                    </div>
                                    @error('phone')
                                        <small class="text-danger d-block mt-1">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-xl-12">
                                    <div class="contact_form_input">
                                        <span><i class="fas fa-list"></i></span>
                                        <input type="text" name="subject" placeholder="প্রজেক্ট বা সার্ভিসের ধরন (উদা: ই-কমার্স ওয়েবসাইট, স্কুল সফটওয়্যার)" value="{{ old('subject') }}" required>
                                    </div>
                                    @error('subject')
                                        <small class="text-danger d-block mt-1">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-xl-12">
                                    <div class="contact_form_input textarea">
                                        <span><i class="fas fa-pen"></i></span>
                                        <textarea rows="5" name="message" placeholder="আপনার প্রজেক্টের বিস্তারিত চাহিদা ও বাজেট উল্লেখ করুন..." required>{{ old('message') }}</textarea>
                                    </div>
                                    @error('message')
                                        <small class="text-danger d-block mt-1">{{ $message }}</small>
                                    @enderror
                                    <button class="common_btn mt_15" type="submit">সাবমিট করুন</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--=============================
        QUOTE PAGE END
    ==============================-->
@endsection
