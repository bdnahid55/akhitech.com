<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\TeamMember;
use Illuminate\Database\Seeder;

class TeamMemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $members = [
            [
                'name' => 'Md Nazrul Islam (Sayed)',
                'slug' => 'md-nazrul-islam-sayed',
                'designation' => 'CEO',
                'image' => 'assets/front/img/team/17384272841396583989.png',
                'bio' => 'আমি একজন প্রফেশনাল লারাভেল ডিজাইনার ও ডেভেলপার, এসইও এবং ডিজিটাল মার্কেটিং স্ট্র্যাটেজিস্ট। ছোট ও মাঝারি ব্যবসাকে অনলাইনে সফল করতে কাজ করি। যেকোনো ধরনের আধুনিক ওয়েব অ্যাপলিকেশন ও সফটওয়্যার তৈরিতে আমি দক্ষ।',
                'facebook' => 'https://facebook.com',
                'twitter' => 'https://twitter.com',
                'linkedin' => 'https://linkedin.com',
                'behance' => 'https://behance.net',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Md Mizanur Rahman',
                'slug' => 'md-mizanur-rahman',
                'designation' => 'Manager',
                'image' => 'assets/front/img/team/1738426713884183570.png',
                'bio' => 'প্রজেক্ট ম্যানেজমেন্ট এবং ক্লায়েন্ট হ্যান্ডলিংয়ে দীর্ঘ অভিজ্ঞতাসম্পন্ন। সঠিক সময়ে প্রজেক্ট ডেলিভারি নিশ্চিত করতে এবং ক্লায়েন্টের সন্তুষ্টি অর্জনে সর্বদা সচেষ্ট।',
                'facebook' => 'https://facebook.com',
                'twitter' => 'https://twitter.com',
                'linkedin' => 'https://linkedin.com',
                'behance' => 'https://behance.net',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Md Nayeem Hossain',
                'slug' => 'md-nayeem-hossain',
                'designation' => 'Web Designer',
                'image' => 'assets/front/img/team/1738426574413867008.png',
                'bio' => 'আধুনিক রেসপনসিভ ওয়েবসাইট এবং ইউজার ইন্টারফেস তৈরিতে পারদর্শী। HTML5, CSS3, JavaScript, Tailwind CSS এবং বুটস্ট্র্যাপ দিয়ে চমৎকার ইউজার এক্সপেরিয়েন্স প্রদান করি।',
                'facebook' => 'https://facebook.com',
                'twitter' => 'https://twitter.com',
                'linkedin' => 'https://linkedin.com',
                'behance' => 'https://behance.net',
                'order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Md Rakibul Islam (Rubel)',
                'slug' => 'md-rakibul-islam-rubel',
                'designation' => 'Graphics Designer',
                'image' => 'assets/front/img/team/1738428069694123271.png',
                'bio' => 'ব্র্যান্ডিং, লোগো ডিজাইন, সোশ্যাল মিডিয়া ব্যানার এবং ক্রিয়েটিভ গ্রাফিক্স ডিজাইনে অভিজ্ঞ। আপনার ব্র্যান্ডের ভাবমূর্তি ফুটিয়ে তুলতে আকর্ষণীয় ডিজাইন উপহার দিই।',
                'facebook' => 'https://facebook.com',
                'twitter' => 'https://twitter.com',
                'linkedin' => 'https://linkedin.com',
                'behance' => 'https://behance.net',
                'order' => 4,
                'is_active' => true,
            ],
        ];

        foreach ($members as $member) {
            TeamMember::updateOrCreate(
                ['slug' => $member['slug']],
                $member
            );
        }
    }
}
