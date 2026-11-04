<?php

namespace Database\Factories;

use App\Models\Portfolio;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Portfolio>
 */
class PortfolioFactory extends Factory
{
    protected $model = Portfolio::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->sentence(3);

        return [
            'title' => $title,
            'slug' => Str::slug($title).'-'.fake()->unique()->numberBetween(100, 999),
            'category' => fake()->randomElement(['ওয়েব ডিজাইন', 'সফটওয়্যার', 'ই-কমার্স', 'মোবাইল অ্যাপ']),
            'image' => 'assets/front/img/portfolio/1736978150325788965.png',
            'client_name' => fake()->company(),
            'start_date' => '01/15/2025',
            'end_date' => '02/10/2025',
            'project_url' => fake()->url(),
            'description' => fake()->paragraph(),
            'is_featured' => true,
            'is_active' => true,
        ];
    }
}
