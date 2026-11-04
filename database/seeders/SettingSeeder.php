<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // General
            ['key' => 'site_name', 'value' => 'Akhitech', 'group' => 'general'],
            ['key' => 'site_tagline', 'value' => 'আইটি সল্যুশন ও সফটওয়্যার সার্ভিস', 'group' => 'general'],
            ['key' => 'header_logo', 'value' => 'assets/front/img/header_logo_17368734951488188050.png', 'group' => 'general'],
            ['key' => 'footer_logo', 'value' => 'assets/front/img/footer_logo17368777782046431399.png', 'group' => 'general'],
            ['key' => 'favicon', 'value' => 'assets/front/img/fav_icon_17368750061518442947.png', 'group' => 'general'],

            // Banner Section
            ['key' => 'banner_subtitle', 'value' => '৬ বছরের বাস্তব অভিজ্ঞতা', 'group' => 'banner'],
            ['key' => 'banner_title', 'value' => 'Creating New Ideas for Your Business', 'group' => 'banner'],
            ['key' => 'banner_description', 'value' => 'আমাদের কাছ থেকে মাত্র ৮০০০ টাকা দিয়ে আপনার স্বপ্নের ওয়েবসাইট ও সফটওয়্যার তৈরি করুন। আপনার ওয়েবসাইট হবে ১০০% রেসপনসিভ, দ্রুতগতির ও নিরাপদ।', 'group' => 'banner'],
            ['key' => 'banner_btn_text', 'value' => 'ফ্রি কনসালটেশন', 'group' => 'banner'],
            ['key' => 'banner_btn_url', 'value' => '/get-quote', 'group' => 'banner'],
            ['key' => 'banner_video_url', 'value' => 'https://youtu.be/#', 'group' => 'banner'],
            ['key' => 'banner_image', 'value' => 'assets/front/img/17361014651911523454.png', 'group' => 'banner'],
            ['key' => 'banner_bg_image', 'value' => 'assets/front/img/17361026461740401592.jpg', 'group' => 'banner'],

            // About Section
            ['key' => 'about_subtitle', 'value' => 'কোম্পানি সম্পর্কে', 'group' => 'about'],
            ['key' => 'about_title', 'value' => 'আমাদের রয়েছে ৬ বছরের পেশাদার অভিজ্ঞতা', 'group' => 'about'],
            ['key' => 'about_description', 'value' => 'হচ্ছে বাংলাদেশের অন্যতম বিশ্বস্ত ডিজিটাল সল্যুশন, সফটওয়্যার ডেভেলপমেন্ট ও ওয়েবসাইট মেইনটেনেন্স এজেন্সি। সাশ্রয়ী মূল্যে সর্বোচ্চ কোয়ালিটির আইটি সেবা প্রদান করাই আমাদের মূল লক্ষ্য।', 'group' => 'about'],
            ['key' => 'about_experience_text', 'value' => '৬ বছরের পরামর্শের অভিজ্ঞতা', 'group' => 'about'],
            ['key' => 'about_feature_1', 'value' => 'ওয়েব ডিজাইন ও ডেভেলপমেন্ট', 'group' => 'about'],
            ['key' => 'about_feature_2', 'value' => 'কাস্টম সফটওয়্যার সল্যুশন', 'group' => 'about'],
            ['key' => 'about_feature_3', 'value' => 'গ্রাফিক্স ও UI/UX ডিজাইন', 'group' => 'about'],
            ['key' => 'about_feature_4', 'value' => 'সার্চ ইঞ্জিন অপটিমাইজেশন (SEO)', 'group' => 'about'],
            ['key' => 'about_counter_1_number', 'value' => '১০০%', 'group' => 'about'],
            ['key' => 'about_counter_1_title', 'value' => 'সফলতার হার', 'group' => 'about'],
            ['key' => 'about_counter_2_number', 'value' => '৪৬৫+', 'group' => 'about'],
            ['key' => 'about_counter_2_title', 'value' => 'সন্তুষ্ট ক্লায়েন্ট', 'group' => 'about'],
            ['key' => 'about_support_title', 'value' => '২৪/৭ সাপোর্ট', 'group' => 'about'],
            ['key' => 'about_support_text', 'value' => 'যেকোন সময়ে, যেকোন সমস্যায়', 'group' => 'about'],
            ['key' => 'about_main_image', 'value' => 'assets/front/img/1736010571398020711.png', 'group' => 'about'],
            ['key' => 'about_small_image', 'value' => 'assets/front/img/1736010555348706608.png', 'group' => 'about'],
            ['key' => 'about_support_image', 'value' => 'assets/front/img/17361016132036935658.png', 'group' => 'about'],

            // Testimonial Section
            ['key' => 'testimonial_subtitle', 'value' => 'প্রশংসা সমূহ', 'group' => 'testimonial'],
            ['key' => 'testimonial_title', 'value' => 'আমাদের ক্লায়েন্টগন কি বলে', 'group' => 'testimonial'],

            // Contact
            ['key' => 'contact_phone', 'value' => '+8801849832178', 'group' => 'contact'],
            ['key' => 'contact_email', 'value' => 'info@akhitech.com', 'group' => 'contact'],
            ['key' => 'contact_address', 'value' => 'হাউজ: মুন্সি বাড়ি, নয়ার হাট স্কুল সংলগ্ন, বড়বাড়ি, লালমনিরহাট, বাংলাদেশ।', 'group' => 'contact'],
            ['key' => 'contact_map_iframe', 'value' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d114942.34865824986!2d89.24584988771971!3d25.918967905856407!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39e330beafc600bb%3A0xe6bf44a706596918!2sLalmonirhat!5e0!3m2!1sen!2sbd!4v1700000000000!5m2!1sen!2sbd', 'group' => 'contact'],

            // Social
            ['key' => 'social_facebook', 'value' => 'https://facebook.com', 'group' => 'social'],
            ['key' => 'social_twitter', 'value' => 'https://twitter.com', 'group' => 'social'],
            ['key' => 'social_linkedin', 'value' => 'https://linkedin.com', 'group' => 'social'],
            ['key' => 'social_youtube', 'value' => 'https://youtube.com', 'group' => 'social'],
            ['key' => 'social_instagram', 'value' => 'https://instagram.com', 'group' => 'social'],

            // Footer
            ['key' => 'footer_about_text', 'value' => 'Akhitech বাংলাদেশের একটি আধুনিক আইটি সেবা প্রদানকারী প্রতিষ্ঠান। আমাদের সব ধরনের সফটওয়্যার এবং ওয়েব সেবা রয়েছে।', 'group' => 'footer'],
            ['key' => 'footer_copyright', 'value' => '© '.date('Y').' সকল কিছুর স্বত্বাধিকার Akhitech', 'group' => 'footer'],

            // Default SEO
            ['key' => 'default_meta_title', 'value' => 'Akhitech | বিশ্বস্ত ওয়েব ডেভেলপমেন্ট ও সফটওয়্যার সল্যুশন', 'group' => 'seo'],
            ['key' => 'default_meta_description', 'value' => 'আখিটেকে স্বাগতম - নির্ভরযোগ্য ওয়েব ডেভেলপমেন্ট, আধুনিক সফটওয়্যার এবং ডিজিটাল আইটি সেবা প্রদানকারী প্রতিষ্ঠান।', 'group' => 'seo'],
            ['key' => 'default_meta_keywords', 'value' => 'web development, software development, laravel, it services bd, web design', 'group' => 'seo'],
            ['key' => 'default_og_image', 'value' => 'assets/front/img/breadcrumb_image_.png', 'group' => 'seo'],
            ['key' => 'google_analytics_id', 'value' => '', 'group' => 'seo'],
            ['key' => 'google_search_console_code', 'value' => '', 'group' => 'seo'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(['key' => $setting['key']], $setting);
        }

        Setting::flushCache();
    }
}
