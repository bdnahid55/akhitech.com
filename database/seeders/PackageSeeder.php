<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Package;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $packages = [
            [
                'name' => 'ই-কমার্স',
                'slug' => 'ecommerce',
                'price' => '10000',
                'currency' => '৳',
                'period' => '/৭ দিনের মধ্যে ডেলিভারি',
                'features' => [
                    'ওয়েব সাইট ইন লারাভেল',
                    '১০০% রেস্পন্সিভ',
                    'ফ্রি ওয়েব ভিউ অ্যাপ',
                    'সিঙ্গেল অথবা মাল্টিভেন্ড্রর',
                    'ইজি চেকাউট সিস্টেম',
                    '১০ জিবি BDIX হোস্টিং',
                    'ফ্রি .com ডোমেন',
                ],
                'button_text' => 'আমি নিতে চাই',
                'button_url' => null,
                'is_featured' => true,
                'is_active' => true,
                'order' => 1,
            ],
            [
                'name' => 'নিউজ পেপার',
                'slug' => 'newspaper',
                'price' => '8000',
                'currency' => '৳',
                'period' => '/৭ দিনের মধ্যে ডেলিভারি',
                'features' => [
                    'ওয়েব সাইট ইন লারাভেল',
                    '১০০% রেস্পন্সিভ',
                    'ফ্রি ওয়েব ভিউ অ্যাপ',
                    'রিপোর্টার সিস্টেম',
                    'এডসেন্স ফ্রেন্ডলি',
                    '১০ জিবি BDIX হোস্টিং',
                    'ফ্রি .com ডোমেন',
                ],
                'button_text' => 'আমি নিতে চাই',
                'button_url' => null,
                'is_featured' => false,
                'is_active' => true,
                'order' => 2,
            ],
            [
                'name' => 'স্কুল ম্যানেজমেন্ট',
                'slug' => 'school-management',
                'price' => '10000',
                'currency' => '৳',
                'period' => '/৭ দিনের মধ্যে ডেলিভারি',
                'features' => [
                    'সফটওয়্যারে ইন লারাভেল',
                    'অনলাইন এডমিশন',
                    'স্টুডেন্ট ম্যানেজমেন্ট সিস্টেম',
                    'অনলাইন ফিস পেমেন্ট',
                    'অনলাইন রেজাল্ট',
                    '১০ জিবি BDIX হোস্টিং',
                    'ফ্রি .com ডোমেন',
                ],
                'button_text' => 'আমি নিতে চাই',
                'button_url' => null,
                'is_featured' => false,
                'is_active' => true,
                'order' => 3,
            ],
            [
                'name' => 'দোকান সফটওয়্যার',
                'slug' => 'shop-pos-management',
                'price' => '8000',
                'currency' => '৳',
                'period' => '/৭ দিনের মধ্যে ডেলিভারি',
                'features' => [
                    'সফটওয়্যার ইন লারাভেল',
                    'কমপ্লিট ইনভেন্ট্ররি সিস্টেম',
                    'অর্ডার ম্যানেজমেন্ট',
                    'লাভ ও ক্ষতির হিসাব',
                    'অনলাইন POS সিস্টেম',
                    '১০ জিবি BDIX হোস্টিং',
                    'ফ্রি .com ডোমেন',
                ],
                'button_text' => 'আমি নিতে চাই',
                'button_url' => null,
                'is_featured' => false,
                'is_active' => true,
                'order' => 4,
            ],
            [
                'name' => 'কুরিয়ার',
                'slug' => 'courier-management',
                'price' => '10000',
                'currency' => '৳',
                'period' => '/৭ দিনের মধ্যে ডেলিভারি',
                'features' => [
                    'সফটওয়্যারে ইন লারাভেল',
                    'পিক আপ রিকুয়েস্ট সিস্টেম',
                    'মার্চেন্ট প্যানেল',
                    'রাইডার প্যানেল',
                    'অনলাইন ট্রাকিং সিস্টেম',
                    '১০ জিবি BDIX হোস্টিং',
                    'ফ্রি .com ডোমেন',
                ],
                'button_text' => 'আমি নিতে চাই',
                'button_url' => null,
                'is_featured' => false,
                'is_active' => true,
                'order' => 5,
            ],
            [
                'name' => 'ফার্মেসী',
                'slug' => 'pharmacy-management',
                'price' => '10000',
                'currency' => '৳',
                'period' => '/৭ দিনের মধ্যে ডেলিভারি',
                'features' => [
                    'সফটওয়্যার ইন লারাভেল',
                    'কমপ্লিট ড্রাগ ইনভেন্ট্ররি সিস্টেম',
                    'এক্সপাইরি নটিফাই অপশন',
                    'লাভ ও ক্ষতির হিসাব',
                    'অনলাইন POS সিস্টেম',
                    '১০ জিবি BDIX হোস্টিং',
                    'ফ্রি .com ডোমেন',
                ],
                'button_text' => 'আমি নিতে চাই',
                'button_url' => null,
                'is_featured' => false,
                'is_active' => true,
                'order' => 6,
            ],
        ];

        foreach ($packages as $data) {
            Package::updateOrCreate(
                ['slug' => $data['slug']],
                $data
            );
        }
    }
}
