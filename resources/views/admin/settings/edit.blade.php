@extends('admin.layouts.app')

@section('title', 'ওয়েবসাইট সেটিংস')
@section('page_title', 'ওয়েবসাইট সেটিংস ও কনফিগারেশন')

@section('content')
    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-12">
                <div class="card card-primary card-outline card-outline-tabs shadow-sm">
                    <div class="card-header p-0 border-bottom-0">
                        <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active font-weight-bold" id="tab-general-link" data-toggle="pill" href="#tab-general" role="tab">
                                    <i class="fas fa-image mr-1"></i> সাধারণ ও লোগো
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link font-weight-bold" id="tab-banner-link" data-toggle="pill" href="#tab-banner" role="tab">
                                    <i class="fas fa-sliders-h mr-1"></i> হোম ব্যানার
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link font-weight-bold" id="tab-about-link" data-toggle="pill" href="#tab-about" role="tab">
                                    <i class="fas fa-info-circle mr-1"></i> এবাউট সেকশন
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link font-weight-bold" id="tab-testimonial-link" data-toggle="pill" href="#tab-testimonial" role="tab">
                                    <i class="fas fa-quote-left mr-1"></i> প্রশংসাপত্র সেকশন
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link font-weight-bold" id="tab-contact-link" data-toggle="pill" href="#tab-contact" role="tab">
                                    <i class="fas fa-address-book mr-1"></i> যোগাযোগ তথ্য
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link font-weight-bold" id="tab-social-link" data-toggle="pill" href="#tab-social" role="tab">
                                    <i class="fas fa-share-alt mr-1"></i> সোশ্যাল মিডিয়া
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link font-weight-bold" id="tab-footer-link" data-toggle="pill" href="#tab-footer" role="tab">
                                    <i class="fas fa-shoe-prints mr-1"></i> ফুটার ও কপিরাইট
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link font-weight-bold" id="tab-seo-link" data-toggle="pill" href="#tab-seo" role="tab">
                                    <i class="fas fa-search mr-1"></i> গ্লোবাল এসইও (SEO)
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="card-body">
                        <div class="tab-content" id="custom-tabs-four-tabContent">
                            <!-- Tab 1: General & Logo -->
                            <div class="tab-pane fade show active" id="tab-general" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label for="site_name">ওয়েবসাইটের নাম (Site Name)</label>
                                        <input type="text" name="site_name" id="site_name" class="form-control" value="{{ old('site_name', $settings['site_name'] ?? '') }}" required>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="site_tagline">ট্যাগলাইন (Tagline)</label>
                                        <input type="text" name="site_tagline" id="site_tagline" class="form-control" value="{{ old('site_tagline', $settings['site_tagline'] ?? '') }}">
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-md-4 form-group">
                                        <label for="header_logo">হেডার লোগো (Header Logo)</label>
                                        @if (!empty($settings['header_logo']))
                                            <div class="p-2 bg-light border rounded mb-2 text-center">
                                                <img src="{{ str_starts_with($settings['header_logo'], 'http') ? $settings['header_logo'] : asset($settings['header_logo']) }}" alt="Header Logo" style="max-height: 50px; max-width: 100%;">
                                            </div>
                                        @endif
                                        <input type="file" name="header_logo" id="header_logo" class="form-control-file" accept="image/*">
                                        <small class="text-muted">প্রস্তাবিত সাইজ: 180x45px (PNG/WebP/SVG)</small>
                                    </div>

                                    <div class="col-md-4 form-group">
                                        <label for="footer_logo">ফুটার লোগো (Footer Logo)</label>
                                        @if (!empty($settings['footer_logo']))
                                            <div class="p-2 bg-dark rounded mb-2 text-center">
                                                <img src="{{ str_starts_with($settings['footer_logo'], 'http') ? $settings['footer_logo'] : asset($settings['footer_logo']) }}" alt="Footer Logo" style="max-height: 50px; max-width: 100%;">
                                            </div>
                                        @endif
                                        <input type="file" name="footer_logo" id="footer_logo" class="form-control-file" accept="image/*">
                                        <small class="text-muted">ডার্ক ব্যাকগ্রাউন্ডের জন্য উপযোগী লোগো</small>
                                    </div>

                                    <div class="col-md-4 form-group">
                                        <label for="favicon">ফেভিকন (Favicon)</label>
                                        @if (!empty($settings['favicon']))
                                            <div class="p-2 bg-light border rounded mb-2 text-center">
                                                <img src="{{ str_starts_with($settings['favicon'], 'http') ? $settings['favicon'] : asset($settings['favicon']) }}" alt="Favicon" style="max-height: 32px;">
                                            </div>
                                        @endif
                                        <input type="file" name="favicon" id="favicon" class="form-control-file" accept="image/*,.ico">
                                        <small class="text-muted">32x32 বা 64x64 (ICO/PNG)</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Tab 2: Home Banner -->
                            <div class="tab-pane fade" id="tab-banner" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label for="banner_subtitle">ব্যানার সাবটাইটেল (Subtitle / Experience Badge)</label>
                                        <input type="text" name="banner_subtitle" id="banner_subtitle" class="form-control" value="{{ old('banner_subtitle', $settings['banner_subtitle'] ?? '') }}" placeholder="যেমন: ৬ বছরের বাস্তব অভিজ্ঞতা">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="banner_title">ব্যানার প্রধান শিরোনাম (Title)</label>
                                        <input type="text" name="banner_title" id="banner_title" class="form-control" value="{{ old('banner_title', $settings['banner_title'] ?? '') }}" placeholder="যেমন: Creating New Ideas for Your Business">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="banner_description">ব্যানার বিবরণ (Description)</label>
                                    <textarea name="banner_description" id="banner_description" rows="3" class="form-control">{{ old('banner_description', $settings['banner_description'] ?? '') }}</textarea>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 form-group">
                                        <label for="banner_btn_text">বাটন লেখা (Button Text)</label>
                                        <input type="text" name="banner_btn_text" id="banner_btn_text" class="form-control" value="{{ old('banner_btn_text', $settings['banner_btn_text'] ?? '') }}" placeholder="ফ্রি কনসালটেশন">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label for="banner_btn_url">বাটন লিঙ্ক (Button URL)</label>
                                        <input type="text" name="banner_btn_url" id="banner_btn_url" class="form-control" value="{{ old('banner_btn_url', $settings['banner_btn_url'] ?? '') }}" placeholder="/get-quote বা কাস্টম লিঙ্ক">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label for="banner_video_url">ভিডিও পপআপ লিঙ্ক (YouTube Video URL)</label>
                                        <input type="text" name="banner_video_url" id="banner_video_url" class="form-control" value="{{ old('banner_video_url', $settings['banner_video_url'] ?? '') }}" placeholder="https://youtu.be/...">
                                    </div>
                                </div>

                                <div class="row mt-2">
                                    <div class="col-md-6 form-group">
                                        <label for="banner_image">ব্যানার প্রধান ছবি (Right Hero Image)</label>
                                        @if (!empty($settings['banner_image']))
                                            <div class="p-2 bg-light border rounded mb-2 text-center">
                                                <img src="{{ str_starts_with($settings['banner_image'], 'http') ? $settings['banner_image'] : asset($settings['banner_image']) }}" alt="Banner" style="max-height: 120px;">
                                            </div>
                                        @endif
                                        <input type="file" name="banner_image" id="banner_image" class="form-control-file" accept="image/*">
                                        <small class="text-muted">PNG/WebP ট্রান্সপারেন্ট ছবি প্রস্তাবিত</small>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label for="banner_bg_image">ব্যানার ব্যাকগ্রাউন্ড ছবি (Background Image)</label>
                                        @if (!empty($settings['banner_bg_image']))
                                            <div class="p-2 bg-light border rounded mb-2 text-center">
                                                <img src="{{ str_starts_with($settings['banner_bg_image'], 'http') ? $settings['banner_bg_image'] : asset($settings['banner_bg_image']) }}" alt="Banner BG" style="max-height: 120px;">
                                            </div>
                                        @endif
                                        <input type="file" name="banner_bg_image" id="banner_bg_image" class="form-control-file" accept="image/*">
                                        <small class="text-muted">JPG/WebP হাই রেজোলিউশন ব্যাকগ্রাউন্ড</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Tab 3: About Section -->
                            <div class="tab-pane fade" id="tab-about" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label for="about_subtitle">এবাউট সাবটাইটেল</label>
                                        <input type="text" name="about_subtitle" id="about_subtitle" class="form-control" value="{{ old('about_subtitle', $settings['about_subtitle'] ?? '') }}" placeholder="কোম্পানি সম্পর্কে">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="about_title">এবাউট প্রধান শিরোনাম</label>
                                        <input type="text" name="about_title" id="about_title" class="form-control" value="{{ old('about_title', $settings['about_title'] ?? '') }}" placeholder="আমাদের রয়েছে ৬ বছরের পেশাদার অভিজ্ঞতা">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="about_description">এবাউট বিস্তারিত বিবরণ (Description)</label>
                                    <textarea name="about_description" id="about_description" rows="4" class="form-control">{{ old('about_description', $settings['about_description'] ?? '') }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label for="about_experience_text">অভিজ্ঞতার টেক্সট (Experience Highlight)</label>
                                    <input type="text" name="about_experience_text" id="about_experience_text" class="form-control" value="{{ old('about_experience_text', $settings['about_experience_text'] ?? '') }}" placeholder="৬ বছরের পরামর্শের অভিজ্ঞতা">
                                </div>

                                <div class="row">
                                    <div class="col-md-3 form-group">
                                        <label for="about_feature_1">ফিচার ১</label>
                                        <input type="text" name="about_feature_1" id="about_feature_1" class="form-control" value="{{ old('about_feature_1', $settings['about_feature_1'] ?? '') }}">
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label for="about_feature_2">ফিচার ২</label>
                                        <input type="text" name="about_feature_2" id="about_feature_2" class="form-control" value="{{ old('about_feature_2', $settings['about_feature_2'] ?? '') }}">
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label for="about_feature_3">ফিচার ৩</label>
                                        <input type="text" name="about_feature_3" id="about_feature_3" class="form-control" value="{{ old('about_feature_3', $settings['about_feature_3'] ?? '') }}">
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label for="about_feature_4">ফিচার ৪</label>
                                        <input type="text" name="about_feature_4" id="about_feature_4" class="form-control" value="{{ old('about_feature_4', $settings['about_feature_4'] ?? '') }}">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3 form-group">
                                        <label for="about_counter_1_number">কাউন্টার ১ সংখ্যা</label>
                                        <input type="text" name="about_counter_1_number" id="about_counter_1_number" class="form-control" value="{{ old('about_counter_1_number', $settings['about_counter_1_number'] ?? '') }}" placeholder="১০০%">
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label for="about_counter_1_title">কাউন্টার ১ শিরোনাম</label>
                                        <input type="text" name="about_counter_1_title" id="about_counter_1_title" class="form-control" value="{{ old('about_counter_1_title', $settings['about_counter_1_title'] ?? '') }}" placeholder="সফলতার হার">
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label for="about_counter_2_number">কাউন্টার ২ সংখ্যা</label>
                                        <input type="text" name="about_counter_2_number" id="about_counter_2_number" class="form-control" value="{{ old('about_counter_2_number', $settings['about_counter_2_number'] ?? '') }}" placeholder="৪৬৫+">
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label for="about_counter_2_title">কাউন্টার ২ শিরোনাম</label>
                                        <input type="text" name="about_counter_2_title" id="about_counter_2_title" class="form-control" value="{{ old('about_counter_2_title', $settings['about_counter_2_title'] ?? '') }}" placeholder="সন্তুষ্ট ক্লায়েন্ট">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label for="about_support_title">সাপোর্ট ব্যাজ শিরোনাম</label>
                                        <input type="text" name="about_support_title" id="about_support_title" class="form-control" value="{{ old('about_support_title', $settings['about_support_title'] ?? '') }}" placeholder="২৪/৭ সাপোর্ট">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="about_support_text">সাপোর্ট ব্যাজ সাবটাইটেল</label>
                                        <input type="text" name="about_support_text" id="about_support_text" class="form-control" value="{{ old('about_support_text', $settings['about_support_text'] ?? '') }}" placeholder="যেকোন সময়ে, যেকোন সমস্যায়">
                                    </div>
                                </div>

                                <div class="row mt-2">
                                    <div class="col-md-4 form-group">
                                        <label for="about_main_image">এবাউট প্রধান ছবি</label>
                                        @if (!empty($settings['about_main_image']))
                                            <div class="p-2 bg-light border rounded mb-2 text-center">
                                                <img src="{{ str_starts_with($settings['about_main_image'], 'http') ? $settings['about_main_image'] : asset($settings['about_main_image']) }}" alt="About Main" style="max-height: 100px;">
                                            </div>
                                        @endif
                                        <input type="file" name="about_main_image" id="about_main_image" class="form-control-file" accept="image/*">
                                    </div>

                                    <div class="col-md-4 form-group">
                                        <label for="about_small_image">এবাউট ছোট ছবি (Small Image)</label>
                                        @if (!empty($settings['about_small_image']))
                                            <div class="p-2 bg-light border rounded mb-2 text-center">
                                                <img src="{{ str_starts_with($settings['about_small_image'], 'http') ? $settings['about_small_image'] : asset($settings['about_small_image']) }}" alt="About Small" style="max-height: 100px;">
                                            </div>
                                        @endif
                                        <input type="file" name="about_small_image" id="about_small_image" class="form-control-file" accept="image/*">
                                    </div>

                                    <div class="col-md-4 form-group">
                                        <label for="about_support_image">এবাউট সাপোর্ট ছবি</label>
                                        @if (!empty($settings['about_support_image']))
                                            <div class="p-2 bg-light border rounded mb-2 text-center">
                                                <img src="{{ str_starts_with($settings['about_support_image'], 'http') ? $settings['about_support_image'] : asset($settings['about_support_image']) }}" alt="About Support" style="max-height: 100px;">
                                            </div>
                                        @endif
                                        <input type="file" name="about_support_image" id="about_support_image" class="form-control-file" accept="image/*">
                                    </div>
                                </div>
                            </div>

                            <!-- Tab: Testimonial Section -->
                            <div class="tab-pane fade" id="tab-testimonial" role="tabpanel">
                                <div class="form-group">
                                    <label for="testimonial_subtitle">প্রশংসাপত্র সাব-শিরোনাম (Subtitle)</label>
                                    <input type="text" name="testimonial_subtitle" id="testimonial_subtitle" class="form-control" value="{{ old('testimonial_subtitle', $settings['testimonial_subtitle'] ?? 'প্রশংসা সমূহ') }}">
                                </div>
                                <div class="form-group">
                                    <label for="testimonial_title">প্রশংসাপত্র মূল শিরোনাম (Main Title)</label>
                                    <input type="text" name="testimonial_title" id="testimonial_title" class="form-control" value="{{ old('testimonial_title', $settings['testimonial_title'] ?? 'আমাদের ক্লায়েন্টগন কি বলে') }}">
                                </div>
                                <div class="callout callout-info mt-4">
                                    <h5><i class="fas fa-info-circle mr-1"></i> প্রশংসাপত্র আইটেমসমূহ পরিচালনা:</h5>
                                    <p class="mb-0">নির্দিষ্ট ক্লায়েন্ট রিভিউ, ছবি এবং রেটিং যোগ বা পরিবর্তনের জন্য সাইডবারের <strong>"কনটেন্ট ম্যানেজমেন্ট > প্রশংসাপত্র / রিভিউ"</strong> মেনু ব্যবহার করুন।</p>
                                </div>
                            </div>

                            <!-- Tab 4: Contact Info -->
                            <div class="tab-pane fade" id="tab-contact" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label for="contact_phone"><i class="fas fa-phone mr-1"></i> যোগাযোগের ফোন / হটলাইন</label>
                                        <input type="text" name="contact_phone" id="contact_phone" class="form-control" value="{{ old('contact_phone', $settings['contact_phone'] ?? '') }}">
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label for="contact_email"><i class="fas fa-envelope mr-1"></i> অফিসিয়াল ইমেইল</label>
                                        <input type="email" name="contact_email" id="contact_email" class="form-control" value="{{ old('contact_email', $settings['contact_email'] ?? '') }}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="contact_address"><i class="fas fa-map-marker-alt mr-1"></i> অফিসের পূর্ণাঙ্গ ঠিকানা</label>
                                    <textarea name="contact_address" id="contact_address" rows="3" class="form-control">{{ old('contact_address', $settings['contact_address'] ?? '') }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label for="contact_map_iframe"><i class="fas fa-map mr-1"></i> গুগল ম্যাপ এমবেড কোড (Google Maps Iframe / URL)</label>
                                    <input type="text" name="contact_map_iframe" id="contact_map_iframe" class="form-control" value="{{ old('contact_map_iframe', $settings['contact_map_iframe'] ?? '') }}">
                                </div>
                            </div>

                            <!-- Tab 5: Social Media -->
                            <div class="tab-pane fade" id="tab-social" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label for="social_facebook"><i class="fab fa-facebook text-primary mr-1"></i> ফেসবুক পেজ URL</label>
                                        <input type="url" name="social_facebook" id="social_facebook" class="form-control" value="{{ old('social_facebook', $settings['social_facebook'] ?? '') }}" placeholder="https://facebook.com/...">
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label for="social_twitter"><i class="fab fa-twitter text-info mr-1"></i> টুইটার / X URL</label>
                                        <input type="url" name="social_twitter" id="social_twitter" class="form-control" value="{{ old('social_twitter', $settings['social_twitter'] ?? '') }}" placeholder="https://x.com/...">
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label for="social_linkedin"><i class="fab fa-linkedin text-primary mr-1"></i> লিংকডইন URL</label>
                                        <input type="url" name="social_linkedin" id="social_linkedin" class="form-control" value="{{ old('social_linkedin', $settings['social_linkedin'] ?? '') }}" placeholder="https://linkedin.com/company/...">
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label for="social_youtube"><i class="fab fa-youtube text-danger mr-1"></i> ইউটিউব চ্যানেল URL</label>
                                        <input type="url" name="social_youtube" id="social_youtube" class="form-control" value="{{ old('social_youtube', $settings['social_youtube'] ?? '') }}" placeholder="https://youtube.com/@...">
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label for="social_instagram"><i class="fab fa-instagram text-danger mr-1"></i> ইনস্টাগ্রাম URL</label>
                                        <input type="url" name="social_instagram" id="social_instagram" class="form-control" value="{{ old('social_instagram', $settings['social_instagram'] ?? '') }}" placeholder="https://instagram.com/...">
                                    </div>
                                </div>
                            </div>

                            <!-- Tab 6: Footer & Copyright -->
                            <div class="tab-pane fade" id="tab-footer" role="tabpanel">
                                <div class="form-group">
                                    <label for="footer_about_text">ফুটার সংক্ষিপ্ত পরিচিতি টেক্সট</label>
                                    <textarea name="footer_about_text" id="footer_about_text" rows="4" class="form-control">{{ old('footer_about_text', $settings['footer_about_text'] ?? '') }}</textarea>
                                    <small class="text-muted">ফুটারের বাম পাশে লোগোর নিচে প্রদর্শিত হবে।</small>
                                </div>

                                <div class="form-group">
                                    <label for="footer_copyright">কপিরাইট টেক্সট</label>
                                    <input type="text" name="footer_copyright" id="footer_copyright" class="form-control" value="{{ old('footer_copyright', $settings['footer_copyright'] ?? '') }}" placeholder="© 2026 সকল কিছুর স্বত্বাধিকার Akhitech">
                                </div>
                            </div>

                            <!-- Tab 7: SEO -->
                            <div class="tab-pane fade" id="tab-seo" role="tabpanel">
                                <div class="form-group">
                                    <label for="default_meta_title">ডিফল্ট এসইও মেটা টাইটেল (Default Meta Title)</label>
                                    <input type="text" name="default_meta_title" id="default_meta_title" class="form-control" value="{{ old('default_meta_title', $settings['default_meta_title'] ?? '') }}">
                                    <small class="text-muted">নির্দিষ্ট পেজে মেটা টাইটেল না থাকলে এটি ব্যবহৃত হবে।</small>
                                </div>

                                <div class="form-group">
                                    <label for="default_meta_description">ডিফল্ট মেটা ডেসক্রিপশন (Default Meta Description)</label>
                                    <textarea name="default_meta_description" id="default_meta_description" rows="3" class="form-control">{{ old('default_meta_description', $settings['default_meta_description'] ?? '') }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label for="default_meta_keywords">ডিফল্ট মেটা কি-ওয়ার্ডস (Keywords)</label>
                                    <input type="text" name="default_meta_keywords" id="default_meta_keywords" class="form-control" value="{{ old('default_meta_keywords', $settings['default_meta_keywords'] ?? '') }}" placeholder="কমা দিয়ে আলাদা করুন">
                                </div>

                                <div class="form-group">
                                    <label for="default_og_image">ডিফল্ট ওপেনগ্রাফ / সোশ্যাল শেয়ার ছবি (Default OG Image)</label>
                                    @if (!empty($settings['default_og_image']))
                                        <div class="mb-2">
                                            <img src="{{ str_starts_with($settings['default_og_image'], 'http') ? $settings['default_og_image'] : asset($settings['default_og_image']) }}" alt="Default OG" class="img-thumbnail" style="max-height: 100px;">
                                        </div>
                                    @endif
                                    <input type="file" name="default_og_image" id="default_og_image" class="form-control-file" accept="image/*">
                                    <small class="text-muted">ফেসবুক, টুইটার ও লিংকডইনে প্রিভিউয়ের জন্য 1200x630px সাইজ প্রস্তাবিত।</small>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label for="google_analytics_id">গুগল অ্যানালিটিক্স আইডি (Google Analytics Measurement ID)</label>
                                        <input type="text" name="google_analytics_id" id="google_analytics_id" class="form-control" value="{{ old('google_analytics_id', $settings['google_analytics_id'] ?? '') }}" placeholder="যেমন: G-XXXXXXXXXX">
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label for="google_search_console_code">গুগল সার্চ কনসোল ভেরিফিকেশন কোড (Search Console Code)</label>
                                        <input type="text" name="google_search_console_code" id="google_search_console_code" class="form-control" value="{{ old('google_search_console_code', $settings['google_search_console_code'] ?? '') }}" placeholder="google-site-verification কোড">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer bg-light text-right">
                        <button type="submit" class="btn btn-primary px-4 font-weight-bold">
                            <i class="fas fa-save mr-1"></i> সকল সেটিংস সংরক্ষণ করুন
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
