<?php

declare(strict_types=1);

return [
    'modules' => [
        'services' => [
            'label' => 'সার্ভিস সমূহ',
            'permissions' => [
                'services.view' => 'সার্ভিস তালিকা ও বিস্তারিত দেখা',
                'services.create' => 'নতুন সার্ভিস তৈরি',
                'services.edit' => 'সার্ভিস সম্পাদনা',
                'services.delete' => 'সার্ভিস মুছে ফেলা',
            ],
        ],
        'packages' => [
            'label' => 'প্যাকেজ / প্রাইসিং',
            'permissions' => [
                'packages.view' => 'প্যাকেজ তালিকা ও বিস্তারিত দেখা',
                'packages.create' => 'নতুন প্যাকেজ তৈরি',
                'packages.edit' => 'প্যাকেজ সম্পাদনা',
                'packages.delete' => 'প্যাকেজ মুছে ফেলা',
            ],
        ],
        'portfolios' => [
            'label' => 'পোর্টফোলিও প্রজেক্ট',
            'permissions' => [
                'portfolios.view' => 'পোর্টফোলিও প্রজেক্ট দেখা',
                'portfolios.create' => 'নতুন প্রজেক্ট তৈরি',
                'portfolios.edit' => 'প্রজেক্ট সম্পাদনা',
                'portfolios.delete' => 'প্রজেক্ট মুছে ফেলা',
            ],
        ],
        'posts' => [
            'label' => 'ব্লগ পোস্ট সমূহ',
            'permissions' => [
                'posts.view' => 'ব্লগ পোস্ট তালিকা দেখা',
                'posts.create' => 'নতুন ব্লগ পোস্ট তৈরি',
                'posts.edit' => 'ব্লগ পোস্ট সম্পাদনা',
                'posts.delete' => 'ব্লগ পোস্ট মুছে ফেলা',
            ],
        ],
        'testimonials' => [
            'label' => 'প্রশংসাপত্র / রিভিউ',
            'permissions' => [
                'testimonials.view' => 'রিভিউ তালিকা দেখা',
                'testimonials.create' => 'নতুন রিভিউ তৈরি',
                'testimonials.edit' => 'রিভিউ সম্পাদনা',
                'testimonials.delete' => 'রিভিউ মুছে ফেলা',
            ],
        ],
        'team' => [
            'label' => 'টিম মেম্বারস',
            'permissions' => [
                'team.view' => 'টিম মেম্বার তালিকা দেখা',
                'team.create' => 'নতুন টিম মেম্বার তৈরি',
                'team.edit' => 'টিম মেম্বার সম্পাদনা',
                'team.delete' => 'টিম মেম্বার মুছে ফেলা',
            ],
        ],
        'achievements' => [
            'label' => 'অর্জন ও কাউন্টার',
            'permissions' => [
                'achievements.view' => 'অর্জন তালিকা দেখা',
                'achievements.create' => 'নতুন অর্জন তৈরি',
                'achievements.edit' => 'অর্জন সম্পাদনা',
                'achievements.delete' => 'অর্জন মুছে ফেলা',
            ],
        ],
        'pages' => [
            'label' => 'কাস্টম পেইজ সমূহ',
            'permissions' => [
                'pages.view' => 'পেইজ তালিকা ও প্রিভিউ দেখা',
                'pages.create' => 'নতুন পেইজ তৈরি',
                'pages.edit' => 'পেইজ সম্পাদনা',
                'pages.delete' => 'পেইজ মুছে ফেলা',
            ],
        ],
        'inquiries' => [
            'label' => 'বার্তা ও কোটেশন',
            'permissions' => [
                'inquiries.view' => 'গ্রাহক বার্তা ও কোটেশন পড়া',
                'inquiries.delete' => 'বার্তা মুছে ফেলা',
            ],
        ],
        'subscribers' => [
            'label' => 'নিউজলেটার গ্রাহক',
            'permissions' => [
                'subscribers.view' => 'সাবস্ক্রাইবার তালিকা দেখা',
                'subscribers.delete' => 'সাবস্ক্রাইবার মুছে ফেলা',
            ],
        ],
        'settings' => [
            'label' => 'ওয়েবসাইট সেটিংস',
            'permissions' => [
                'settings.view' => 'সেটিংস পেজ দেখা',
                'settings.edit' => 'সেটিংস পরিবর্তন ও সংরক্ষণ',
            ],
        ],
        'admins' => [
            'label' => 'এডমিন ও রোল ম্যানেজমেন্ট',
            'permissions' => [
                'admins.view' => 'এডমিন তালিকা দেখা',
                'admins.create' => 'নতুন এডমিন তৈরি',
                'admins.edit' => 'এডমিন একাউন্ট সম্পাদনা',
                'admins.delete' => 'এডমিন একাউন্ট মুছে ফেলা',
                'roles.manage' => 'রোল তৈরি, সম্পাদনা ও পারমিশন অ্যাসাইন',
            ],
        ],
    ],
];
