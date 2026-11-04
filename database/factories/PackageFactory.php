<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Package;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Package>
 */
class PackageFactory extends Factory
{
    protected $model = Package::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->words(2, true);

        return [
            'name' => ucfirst($name),
            'slug' => Str::slug($name).'-'.fake()->unique()->numberBetween(100, 999),
            'price' => (string) fake()->numberBetween(5000, 30000),
            'currency' => '৳',
            'period' => '/৭ দিনের মধ্যে ডেলিভারি',
            'features' => [
                'ওয়েব সাইট ইন লারাভেল',
                '১০০% রেস্পন্সিভ',
                'ফ্রি ওয়েব ভিউ অ্যাপ',
                '১০ জিবি BDIX হোস্টিং',
                'ফ্রি .com ডোমেন',
            ],
            'button_text' => 'আমি নিতে চাই',
            'button_url' => null,
            'is_featured' => false,
            'is_active' => true,
            'order' => 0,
        ];
    }
}
