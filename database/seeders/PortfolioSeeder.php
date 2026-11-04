<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Portfolio;
use Illuminate\Database\Seeder;

class PortfolioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $portfolios = [
            [
                'title' => 'Source the products',
                'slug' => 'source-the-products',
                'category' => 'ওয়েব ডিজাইন ও ডেভেলপমেন্ট',
                'image' => 'assets/front/img/portfolio/1736978150325788965.png',
                'client_name' => 'Source the products',
                'start_date' => '01/15/2025',
                'end_date' => '02/10/2025',
                'project_url' => 'https://www.sourcetheproducts.com/',
                'description' => '<p>আন্তর্জাতিক ক্রেতাদের জন্য তৈরি করা পণ্য সোর্সিং ও সাপ্লাই চেইন ম্যানেজমেন্ট ওয়েব পোর্টাল। এটি আধুনিক UI/UX এবং উচ্চগতির পারফরম্যান্স নিশ্চিত করে তৈরি করা হয়েছে।</p><p>প্রজেক্টটির মাধ্যমে বিভিন্ন দেশের বায়ার ও সরবরাহকারীদের মধ্যে সরাসরি যোগাযোগ ও অর্ডার প্রসেসিংয়ের ব্যবস্থা করা হয়েছে।</p>',
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'title' => 'AJker Bazar',
                'slug' => 'ajker-bazar',
                'category' => 'ই-কমার্স সল্যুশন',
                'image' => 'assets/front/img/portfolio/17369783051078293316.png',
                'client_name' => 'Ajker Bazar BD',
                'start_date' => '02/01/2025',
                'end_date' => '03/05/2025',
                'project_url' => 'https://ajkerbazar.com',
                'description' => '<p>মাল্টি-ভেন্ডর সক্ষমতা ও স্বয়ংক্রিয় পেমেন্ট গেটওয়ে সহ পূর্ণাঙ্গ অনলাইন শপিং প্ল্যাটফর্ম। আধুনিক কার্ট, উইশলিস্ট ও রিয়েল-টাইম অর্ডার ট্র্যাকিং যুক্ত।</p>',
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'title' => 'দৈনিক জনতার বাংলাদেশ',
                'slug' => 'doinik-jantar-bangladesh',
                'category' => 'অনলাইন নিউজ পোর্টাল',
                'image' => 'assets/front/img/portfolio/17369787161097662197.png',
                'client_name' => 'দৈনিক জনতার বাংলাদেশ',
                'start_date' => '11/10/2024',
                'end_date' => '12/25/2024',
                'project_url' => 'https://www.dailyjanatarbangladesh.com',
                'description' => '<p>উচ্চ ট্রাফিক হ্যান্ডেল করার মতো দ্রুতগতির এবং মোবাইল-অপ্টিমাইজড বাংলা ই-পেপার ও নিউজ পোর্টাল। স্বয়ংক্রিয় ক্যাশিং এবং এসইও ফ্রেন্ডলি আর্কিটেকচার।</p>',
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'title' => 'স্বাধীন একাত্তর',
                'slug' => 'swadhin-ekattor',
                'category' => 'অনলাইন নিউজ মিডিয়া',
                'image' => 'assets/front/img/portfolio/1736978810139023612.png',
                'client_name' => 'স্বাধীন একাত্তর মিডিয়া',
                'start_date' => '09/05/2024',
                'end_date' => '10/20/2024',
                'project_url' => 'https://shadinekattor.news',
                'description' => '<p>লাইভ ভিডিও স্ট্রিমিং ও ব্রেকিং নিউজ নোটিফিকেশন সহ আধুনিক মিডিয়া ওয়েবসাইট। গুগল অ্যাডসেন্স ও বিজ্ঞাপন নেটওয়ার্কের জন্য প্রস্তুত।</p>',
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'title' => 'পুলিশ লাইন্স স্কুল অ্যান্ড কলেজ',
                'slug' => 'police-lines-school-and-college',
                'category' => 'এডুকেশন ম্যানেজমেন্ট',
                'image' => 'assets/front/img/portfolio/17369788831900935665.png',
                'client_name' => 'ফাকল পুলিশ লাইন্স স্কুল অ্যান্ড কলেজ',
                'start_date' => '08/01/2024',
                'end_date' => '09/30/2024',
                'project_url' => 'https://phakal.edu.bd',
                'description' => '<p>অনলাইন ভর্তি, রেজাল্ট প্রকাশ ও স্টুডেন্ট-টিচার পোর্টাল সহ সম্পূর্ণ শিক্ষাপ্রতিষ্ঠান অটোমেশন সফটওয়্যার ও তথ্যবহুল পোর্টাল।</p>',
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'title' => 'Quick Pharma',
                'slug' => 'quick-pharma',
                'category' => 'ফার্মাসিউটিক্যাল সল্যুশন',
                'image' => 'assets/front/img/portfolio/1738437944359664959.png',
                'client_name' => 'Quick Pharma BD',
                'start_date' => '07/15/2024',
                'end_date' => '08/30/2024',
                'project_url' => 'https://quickpharma.com.bd',
                'description' => '<p>ফার্মেসি ইনভেন্টরি, প্রেসক্রিপশন আপলোড ও ওষুধ ডেলিভারি সিস্টেম ম্যানেজমেন্ট সফটওয়্যার। কাস্টমার ও ফার্মাসিস্ট ড্যাশবোর্ড অন্তর্ভুক্ত।</p>',
                'is_featured' => true,
                'is_active' => true,
            ],
        ];

        foreach ($portfolios as $portfolio) {
            Portfolio::updateOrCreate(['slug' => $portfolio['slug']], $portfolio);
        }
    }
}
