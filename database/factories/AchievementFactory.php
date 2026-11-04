<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Achievement;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Achievement>
 */
class AchievementFactory extends Factory
{
    protected $model = Achievement::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->words(2, true),
            'count' => (string) fake()->numberBetween(50, 999),
            'suffix' => '+',
            'icon' => 'fas fa-trophy',
            'order' => fake()->numberBetween(0, 10),
            'is_active' => true,
        ];
    }
}
