<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $testimonials = [
            [
                'name' => 'ফাতেমা আক্তার',
                'designation' => 'উদ্যোক্তা',
                'image' => 'assets/front/img/17362348801814731466.png',
                'comment' => 'আমরা আমাদের নতুন ওয়েবসাইটের সমস্ত দিক নিয়ে খুব মুগ্ধ হয়েছি। আমরা একটি ওয়েবসাইট তৈরি করে ছিলাম ক্রিয়েটিভ ডিজাইন থেকে, ধন্যবাদ।',
                'rating' => 5,
                'order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'খালেদ মাহমুদ',
                'designation' => 'ম্যানেজার',
                'image' => 'assets/front/img/17362347301097715037.png',
                'comment' => 'আমি ক্রিয়েটিভ ডিজাইনের সাথে কাজ করতে পেরে খুব খুশি। তারা খুব বন্ধুত্বপূর্ণ, তারা আমার কাজটি খুব সুন্দরভাবে করেছে। ধন্যবাদ ক্রিয়েটিভ ডিজাইন।',
                'rating' => 5,
                'order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'আকবর হোসেন',
                'designation' => 'প্রেসিডেন্ট',
                'image' => 'assets/front/img/1736235053786629294.png',
                'comment' => 'আমি আমার নতুন PTC সাইট তৈরি করেছি, ক্রিয়েটিভ ডিজাইন থেকে আমি যা চেয়েছিলাম তা পেয়েছি। এটা খুব সুন্দর ছিল এর জন্য ক্রিয়েটিভ ডিজাইনকে ধন্যবাদ।',
                'rating' => 5,
                'order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'নাজমুল হাসান',
                'designation' => 'নির্বাহী পরিচালক',
                'image' => 'assets/front/img/173623517594248820.png',
                'comment' => 'আমি আমার ওয়েবসাইটের জন্য তাদের কাছ থেকে SEO পরিষেবা নিয়েছিলাম। তাদের কাছ থেকে সেবা পাওয়ার পর আমার ওয়েবসাইটের ট্রাফিক অনেক বেড়ে গেছে',
                'rating' => 5,
                'order' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'নাসির শেখ',
                'designation' => 'প্রেসিডেন্ট',
                'image' => 'assets/front/img/1736235319620330853.png',
                'comment' => 'তাদের কাজ আশ্চর্যজনক। কিছু দিন আগে আমি ক্রিয়েটিভ ডিজাইন থেকে একটি ই-কমার্স ওয়েবসাইট তৈরি করেছি। ক্রিয়েটিভ ডিজাইনকে ধন্যবাদ',
                'rating' => 5,
                'order' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'জিয়া হাসান',
                'designation' => 'কো-সিইও',
                'image' => 'assets/front/img/17362346181434000873.png',
                'comment' => 'ক্রিয়েটিভ ডিজাইন এর সাথে কাজ করতে পেরে আমি খুবই খুশি। তারা খুব সহায়ক. তাদের কাস্টমার সাপোর্ট খুবই ভালো।',
                'rating' => 5,
                'order' => 6,
                'is_active' => true,
            ],
        ];

        foreach ($testimonials as $data) {
            Testimonial::updateOrCreate(
                ['name' => $data['name']],
                $data
            );
        }
    }
}
