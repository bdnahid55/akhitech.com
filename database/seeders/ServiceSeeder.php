<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'title' => 'ওয়েব ডিজাইন ও ডেভেলপমেন্ট',
                'slug' => 'web-design-and-development',
                'icon' => 'fas fa-palette',
                'short_description' => 'আমাদের ওয়েব ডিজাইন ও ডেভেলপমেন্ট প্যাকেজ শুরু ৮০০০ টাকা থেকে। ১০০% রেসপনসিভ ও নিরাপদ।',
                'description' => 'আধুনিক কোডিং স্ট্যান্ডার্ড এবং Laravel/PHP ফ্রেমওয়ার্ক দিয়ে তৈরি করা হয় আপনার স্বপ্নের ওয়েবসাইট। সাথে থাকছে সুপারফাস্ট স্পিড ও ইউজার ফ্রেন্ডলি কন্ট্রোল প্যানেল।',
                'starting_price' => 8000,
                'order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'সফটওয়্যার ডেভেলপমেন্ট',
                'slug' => 'software-development',
                'icon' => 'fas fa-laptop-code',
                'short_description' => 'আমাদের সফটওয়্যার ডেভেলপমেন্ট প্যাকেজ শুরু ১০০০০ টাকা থেকে।',
                'description' => 'যেকোনো ব্যবসা, হাসপাতাল, স্কুল বা প্রতিষ্ঠানের দৈনন্দিন কাজ স্বয়ংক্রিয় করতে কাস্টম ERP, অ্যাকাউন্টিং ও ইনভেন্টরি সফটওয়্যার ডেভেলপমেন্ট।',
                'starting_price' => 10000,
                'order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'এসইও (SEO) সার্ভিস',
                'slug' => 'seo-services',
                'icon' => 'fab fa-google',
                'short_description' => 'আমাদের এসইও এর সকল সার্ভিস প্যাকেজ শুরু ৩০০০ টাকা থেকে।',
                'description' => 'গুগলে আপনার ব্যবসাকে র‍্যাঙ্ক করাতে অন-পেজ, অফ-পেজ এবং টেকনিক্যাল এসইও অডিট সার্ভিস।',
                'starting_price' => 3000,
                'order' => 3,
                'is_active' => true,
            ],
            [
                'title' => 'ডোমেন, হোস্টিং ও সার্ভার',
                'slug' => 'domain-hosting-and-server',
                'icon' => 'fas fa-server',
                'short_description' => 'আমাদের ডোমেন এবং হোস্টিং এর প্যাকেজ শুরু ৩০০০ টাকা থেকে।',
                'description' => 'হাই স্পিড NVMe SSD সার্ভার, ফ্রি SSL সার্টিফিকেট, এবং ৯৯.৯% আপটাইম নিশ্চয়তা সহ রিলায়েবল হোস্টিং সল্যুশন।',
                'starting_price' => 3000,
                'order' => 4,
                'is_active' => true,
            ],
            [
                'title' => 'সোশ্যাল মিডিয়া মার্কেটিং',
                'slug' => 'social-media-marketing',
                'icon' => 'fab fa-facebook-f',
                'short_description' => 'আমাদের সোশ্যাল মিডিয়া মার্কেটিং প্যাকেজ শুরু ২০০০ টাকা থেকে।',
                'description' => 'টার্গেটেড অডিয়েন্স রিসার্চ এবং আকর্ষণীয় কনটেন্টের সাহায্যে সেলস ও ব্র্যান্ড ভ্যালু বাড়ানোর সোশ্যাল মিডিয়া ক্যাম্পেইন।',
                'starting_price' => 2000,
                'order' => 5,
                'is_active' => true,
            ],
            [
                'title' => 'গ্রাফিক্স ডিজাইন এর সার্ভিস',
                'slug' => 'graphic-design-services',
                'icon' => 'fas fa-crop-alt',
                'short_description' => 'আমাদের গ্রাফিক্স ডিজাইন এর সকল প্যাকেজ শুরু ৫০০০ টাকা থেকে।',
                'description' => 'ব্যবসায়িক লোগো, সোশ্যাল মিডিয়া ব্যানার, ফ্লায়ার, ক্যাটালগ ও প্যাকেজিং এর জন্য ইউনিক গ্রাফিক্স ডিজাইন।',
                'starting_price' => 5000,
                'order' => 6,
                'is_active' => true,
            ],
            [
                'title' => 'UI/UX ডিজাইন এর সার্ভিস',
                'slug' => 'ui-ux-design-services',
                'icon' => 'fas fa-paint-brush',
                'short_description' => 'আমাদের UI/UX ডিজাইন এর সার্ভিস প্যাকেজ শুরু ১০০০ টাকা থেকে।',
                'description' => 'ওয়েব ও মোবাইল অ্যাপ্লিকেশনের জন্য ব্যবহারকারী-বান্ধব এবং দৃষ্টিনন্দন Figma প্রোটোটাইপ ও ইউজার ফ্লো ডিজাইন।',
                'starting_price' => 1000,
                'order' => 7,
                'is_active' => true,
            ],
            [
                'title' => 'প্রোডাক্ট ব্র্যান্ডিং ও প্যাকেজিং',
                'slug' => 'product-branding-and-packaging',
                'icon' => 'fas fa-lightbulb',
                'short_description' => 'আমাদের প্রোডাক্ট ব্র্যান্ডিং ও ডিজাইন প্যাকেজ শুরু ৮০০০ টাকা থেকে।',
                'description' => 'আপনার ব্র্যান্ডের জন্য কমপ্লিট কর্পোরেট আইডেন্টিটি ও প্যাকেজিং ডিজাইন গাইডলাইন।',
                'starting_price' => 8000,
                'order' => 8,
                'is_active' => true,
            ],
        ];

        foreach ($services as $service) {
            Service::updateOrCreate(['slug' => $service['slug']], $service);
        }
    }
}
