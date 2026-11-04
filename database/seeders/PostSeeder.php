<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $posts = [
            [
                'title' => 'সফটওয়্যার এজেন্সি বেছে নেওয়ার ৫টি গুরুত্বপূর্ণ টিপস',
                'slug' => '5-tips-for-choosing-software-agency',
                'excerpt' => 'আপনার ব্যবসায়ের ডিজিটাল রূপান্তরের জন্য সঠিক টেকনোলজি পার্টনার নির্বাচন করা অত্যন্ত জরুরি।',
                'content' => 'সঠিক সফটওয়্যার এজেন্সি নির্বাচন আপনার ব্যবসায়ের প্রবৃদ্ধিকে বহুগুণ বাড়িয়ে দিতে পারে। টিম দক্ষতা, পোর্টফোলিও, প্রজেক্ট ম্যানেজমেন্ট এবং পোস্ট-লঞ্চ সাপোর্ট যাচাই করে সিদ্ধান্ত নিন।',
                'image' => 'assets/front/img/blog/17369699791678462702.png',
                'author' => 'এডমিন',
                'published_at' => now()->subDays(5),
                'is_published' => true,
            ],
            [
                'title' => 'সোশ্যাল মিডিয়া মার্কেটিং কেন গুরুত্বপূর্ণ এবং এর সুবিধা কি',
                'slug' => 'why-social-media-marketing-is-important',
                'excerpt' => 'ডিজিটাল মার্কেটিংয়ের মাধ্যমে খুব কম খরচে আপনার পণ্য ও সেবার প্রচার করতে পারেন সম্ভাব্য গ্রাহকদের কাছে।',
                'content' => 'বর্তমান যুগে সোশ্যাল মিডিয়া মার্কেটিং ছাড়া ব্যবসায়িক প্রসার অসম্ভব। ফেসবুক, ইনস্টাগ্রাম এবং ইউটিউবের মাধ্যমে সঠিক গ্রাহকদের কাছে আপনার পণ্যের বার্তা পৌঁছে দেওয়া সম্ভব।',
                'image' => 'assets/front/img/blog/1736970628858753836.png',
                'author' => 'এডমিন',
                'published_at' => now()->subDays(10),
                'is_published' => true,
            ],
            [
                'title' => 'UI & UX ডিজাইন ও ভবিষ্যৎ ক্যারিয়ার সম্ভাবনা',
                'slug' => 'ui-ux-design-career-opportunities',
                'excerpt' => 'ইউজার এক্সপেরিয়েন্স এবং ইন্টারফেস ডিজাইন যেকোনো সফল সফটওয়্যারের মেরুদণ্ড হিসেবে কাজ করে।',
                'content' => 'একটি অ্যাপ বা ওয়েবসাইটের সাফল্য নির্ভর করে গ্রাহক কতটা সহজে এবং স্বাচ্ছন্দ্যে তা ব্যবহার করতে পারছেন। বিশ্ববাজারে UI/UX ডিজাইনারদের চাহিদা এখন আকাশচুম্বী।',
                'image' => 'assets/front/img/blog/17369712521247617361.png',
                'author' => 'এডমিন',
                'published_at' => now()->subDays(15),
                'is_published' => true,
            ],
        ];

        foreach ($posts as $post) {
            Post::updateOrCreate(['slug' => $post['slug']], $post);
        }
    }
}
