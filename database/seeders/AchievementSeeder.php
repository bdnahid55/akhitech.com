<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Achievement;
use Illuminate\Database\Seeder;

class AchievementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $achievements = [
            [
                'title' => 'কমপ্লিট প্রোজেক্ট',
                'count' => '568',
                'suffix' => '+',
                'icon' => 'fas fa-check-double',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'সেটিস্ফাইড কাস্টমার',
                'count' => '456',
                'suffix' => '+',
                'icon' => 'fas fa-smile',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'গ্রোইং বিজনেস',
                'count' => '256',
                'suffix' => '+',
                'icon' => 'fas fa-chart-line',
                'order' => 3,
                'is_active' => true,
            ],
            [
                'title' => 'সাপোর্ট টিম',
                'count' => '65',
                'suffix' => '+',
                'icon' => 'fas fa-headset',
                'order' => 4,
                'is_active' => true,
            ],
        ];

        foreach ($achievements as $achievement) {
            Achievement::updateOrCreate(
                ['title' => $achievement['title']],
                $achievement
            );
        }
    }
}
