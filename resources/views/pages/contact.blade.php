@extends('layouts.app')

@section('title', 'যোগাযোগ')

@section('content')
    @include('layouts.partials.breadcrumb', ['title' => 'আমাদের সাথে যোগাযোগ করুন', 'subtitle' => 'যোগাযোগ'])

    <!--=============================
        CONTACT PAGE START
    ==============================-->
    <section class="contact mt_120 xs_mt_80 mb_120 xs_mb_80">
        <div class="container">
            <div class="contact_form_area">
                <div class="row">
                    <div class="col-xl-5 col-lg-5 wow fadeInUp" data-wow-duration="1s">
                        <div class="contact_info_area">
                            <div class="contact_info">
                                <h3>হটলাইন নাম্বার</h3>
                                <p><a href="tel:{{ $siteSettings['contact_phone'] ?? '+8801849832178' }}">{{ $siteSettings['contact_phone'] ?? '+8801849832178' }}</a></p>
                            </div>
                            <div class="contact_info">
                                <h3>ইমেইল এড্রেস</h3>
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

                        <form class="contact_form" action="{{ route('contact.submit') }}" method="POST">
                            @csrf
                            <h3>যোগাযোগ করতে নিচের ফরম পূরণ করুন</h3>
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
                                        <span><i class="fas fa-book"></i></span>
                                        <input type="text" name="subject" placeholder="বিষয়" value="{{ old('subject') }}" required>
                                    </div>
                                    @error('subject')
                                        <small class="text-danger d-block mt-1">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-xl-12">
                                    <div class="contact_form_input textarea">
                                        <span><i class="fas fa-pen"></i></span>
                                        <textarea rows="5" name="message" placeholder="আপনার বার্তা লিখুন..." required>{{ old('message') }}</textarea>
                                    </div>
                                    @error('message')
                                        <small class="text-danger d-block mt-1">{{ $message }}</small>
                                    @enderror
                                    <button class="common_btn mt_15" type="submit">মেসেজ পাঠান</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="contact_map_area">
                <div class="row mt_120 xs_mt_80">
                    <div class="col-12 wow fadeInUp" data-wow-duration="1s">
                        <div class="contact_map">
                            @php
                                $mapEmbed = $siteSettings['contact_map_iframe'] ?? 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d114942.34865824986!2d89.24584988771971!3d25.918967905856407!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39e330beafc600bb%3A0xe6bf44a706596918!2sLalmonirhat!5e0!3m2!1sen!2sbd!4v1700000000000!5m2!1sen!2sbd';
                            @endphp
                            @if(str_contains($mapEmbed, '<iframe'))
                                {!! $mapEmbed !!}
                            @else
                                <iframe src="{{ $mapEmbed }}" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--=============================
        CONTACT PAGE END
    ==============================-->
@endsection
