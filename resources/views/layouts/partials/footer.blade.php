<!--==============================
    FOOTER START
===============================-->
<footer class="footer pt_100 xs_pt_60">
    <div class="container">
        <!-- Footer Contact Info Bar -->
        <div class="row pb_55">
            <div class="col-lg-4 col-sm-12">
                <div class="footer_contact">
                    <h4>আমাদের ইমেইল</h4>
                    <p>
                        <a href="mailto:{{ $siteSettings['contact_email'] ?? 'info@akhitech.com' }}">{{ $siteSettings['contact_email'] ?? 'info@akhitech.com' }}</a>
                    </p>
                </div>
            </div>
            <div class="col-lg-4 col-sm-12">
                <div class="footer_contact">
                    <h4>আমাদের হটলাইন</h4>
                    <p>
                        <a href="tel:{{ $siteSettings['contact_phone'] ?? '+8801849832178' }}">{{ $siteSettings['contact_phone'] ?? '+8801849832178' }}</a>
                    </p>
                </div>
            </div>
            <div class="col-lg-4 col-sm-12">
                <div class="footer_contact contact_with">
                    <h4>সোশ্যাল মিডিয়া</h4>
                    <ul class="d-flex flex-wrap">
                        @if(!empty($siteSettings['social_facebook']))
                            <li>
                                <a href="{{ $siteSettings['social_facebook'] }}" target="_blank" rel="noopener" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                            </li>
                        @endif
                        @if(!empty($siteSettings['social_twitter']))
                            <li>
                                <a href="{{ $siteSettings['social_twitter'] }}" target="_blank" rel="noopener" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                            </li>
                        @endif
                        @if(!empty($siteSettings['social_linkedin']))
                            <li>
                                <a href="{{ $siteSettings['social_linkedin'] }}" target="_blank" rel="noopener" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                            </li>
                        @endif
                        @if(!empty($siteSettings['social_youtube']))
                            <li>
                                <a href="{{ $siteSettings['social_youtube'] }}" target="_blank" rel="noopener" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                            </li>
                        @endif
                        @if(!empty($siteSettings['social_instagram']))
                            <li>
                                <a href="{{ $siteSettings['social_instagram'] }}" target="_blank" rel="noopener" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>

        <div class="footer_body pt_75 pb_75 xs_pt_50 xs_pb_50">
            <div class="row justify-content-between">
                <div class="col-xl-3 col-lg-3 col-md-6">
                    <div class="footer_content xs_mb_50">
                        <a class="footer_logo" href="{{ route('home') }}">
                            <img src="{{ !empty($siteSettings['footer_logo']) ? (str_starts_with($siteSettings['footer_logo'], 'http') ? $siteSettings['footer_logo'] : asset($siteSettings['footer_logo'])) : asset('assets/front/img/footer_logo17368777782046431399.png') }}" alt="{{ $siteSettings['site_name'] ?? config('app.name', 'Akhitech') }}" class="img-fluid w-100" />
                        </a>
                        <p class="footer_description pt_40 sm_pt_20 sm_pb_20">
                            {{ $siteSettings['footer_about_text'] ?? ($siteSettings['site_name'] ?? config('app.name', 'Akhitech')) . ' বাংলাদেশের একটি আধুনিক আইটি সেবা প্রদানকারী প্রতিষ্ঠান। আমাদের সব ধরনের সফটওয়্যার এবং ওয়েব সেবা রয়েছে।' }}
                        </p>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-2 col-sm-6 col-md-6 xs_mb_50">
                    <div class="footer_content">
                        <h3>দ্রুত লিংক</h3>
                        <ul class="footer_link">
                            <li><a href="{{ route('home') }}">হোম</a></li>
                            <li><a href="{{ route('about') }}">আমাদের সম্পর্কে</a></li>
                            <li><a href="{{ route('services') }}">আমাদের সার্ভিস</a></li>
                            <li><a href="{{ route('portfolio') }}">প্রজেক্ট সমূহ</a></li>
                            <li><a href="{{ route('blog') }}">লেটেস্ট ব্লগ</a></li>
                            <li><a href="{{ route('contact') }}">যোগাযোগ করুন</a></li>
                            @if(isset($footerQuickPages))
                                @foreach($footerQuickPages as $fPage)
                                    <li><a href="{{ route('page.show', $fPage->slug) }}">{{ $fPage->title }}</a></li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-2 col-sm-6 col-md-6 xs_mb_50">
                    <div class="footer_content">
                        <h3>আইনি নীতিমালা</h3>
                        <ul class="footer_link">
                            <li><a href="{{ route('privacy') }}">প্রাইভেসি পলিসি</a></li>
                            <li><a href="{{ route('terms') }}">টার্মস ও কন্ডিশনস</a></li>
                            <li><a href="{{ route('quote') }}">ফ্রি কনসালটেশন</a></li>
                            <li><a href="{{ route('contact') }}">সাপোর্ট</a></li>
                            @if(isset($footerLegalPages))
                                @foreach($footerLegalPages as $fPage)
                                    <li><a href="{{ route('page.show', $fPage->slug) }}">{{ $fPage->title }}</a></li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-6 xs_mb_30">
                    <div class="footer_content">
                        <h3>নিউজলেটার</h3>
                        <p class="pb_20">
                            আমাদের সকল আপডেট অফার পেতে, আমাদের সাথে কানেক্ট থাকতে ইমেইল এর মাধ্যমে সাবস্ক্রাইব করুন।
                        </p>
                        @if (session('newsletter_success'))
                            <div class="alert alert-success py-2 px-3 mb-3" role="alert">
                                {{ session('newsletter_success') }}
                            </div>
                        @endif
                        <form action="{{ route('newsletter.store') }}" method="POST">
                            @csrf
                            <div class="subscribe">
                                <input type="email" name="email" placeholder="আপনার ইমেইল দিন..." required value="{{ old('email') }}" />
                                <span><i class="fas fa-envelope"></i></span>
                            </div>
                            @error('email')
                                <small class="text-danger mt-1 d-block">{{ $message }}</small>
                            @enderror
                            <button class="mt_25" type="submit">সাবস্ক্রাইব করুন</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer_bottom pt_45 pb_45 xs_pb_25">
            <div class="row align-items-center">
                <div class="col-xl-6 col-lg-5">
                    <div class="copy">
                        <p>{{ $siteSettings['footer_copyright'] ?? ('© ' . date('Y') . ' সকল কিছুর স্বত্বাধিকার ' . ($siteSettings['site_name'] ?? config('app.name', 'Akhitech'))) }}</p>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-7">
                    <div class="footer_right_bottom">
                        <div class="payment ml_30 xs_ml_0">
                            <p>পেমেন্ট মেথড :</p>
                            <div>
                                <img src="{{ asset('assets/frontend/images/payment.png') }}" alt="payment-methods" class="img-fluid w-100">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!--==============================
    FOOTER END
===============================-->

<!--==============================
    SCROLL BUTTON START
===============================-->
<div class="scroll_btn">
    <i class="fas fa-chevron-up"></i>
</div>
<!--==============================
    SCROLL BUTTON END
===============================-->
