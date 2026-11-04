<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pages = [
            [
                'title' => 'সাধারণ প্রশ্নোত্তর (FAQ)',
                'slug' => 'faq',
                'content' => '<h3>সচরাচর জিজ্ঞাসিত প্রশ্নাবলী</h3><p><strong>প্রশ্ন: ওয়েবসাইট তৈরি করতে কত দিন সময় লাগে?</strong><br>উত্তর: সাধারণ ওয়েবসাইটের জন্য ৭-১০ দিন এবং কাস্টম সফটওয়্যার বা বড় প্রজেক্টের ক্ষেত্রে কাজের পরিধি অনুযায়ী সময় লাগে।</p><p><strong>প্রশ্ন: প্রজেক্ট ডেলিভারির পর কি ফ্রি সাপোর্ট দেওয়া হয়?</strong><br>উত্তর: হ্যাঁ, প্রতিটি প্রজেক্টের সাথে নির্দিষ্ট মেয়াদের জন্য সম্পূর্ণ ফ্রি বাগ ফিক্সিং ও সাপোর্ট প্রদান করা হয়।</p>',
                'show_in_header' => true,
                'show_in_footer' => true,
                'footer_column' => 'quick_links',
                'order' => 2,
                'is_active' => true,
                'meta_title' => 'সাধারণ প্রশ্নোত্তর | FAQ | Akhitech',
                'meta_description' => 'ওয়েবসাইট ও সফটওয়্যার সার্ভিস সম্পর্কিত সচরাচর জিজ্ঞাসিত প্রশ্নের উত্তর পড়ুন।',
                'meta_keywords' => 'faq, questions, web development questions',
            ],
        ];

        foreach ($pages as $page) {
            Page::updateOrCreate(['slug' => $page['slug']], $page);
        }
    }
}
