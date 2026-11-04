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
