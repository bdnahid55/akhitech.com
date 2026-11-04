<?php

namespace Database\Factories;

use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Service>
 */
class ServiceFactory extends Factory
{
    protected $model = Service::class;

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
            'icon' => 'fas fa-laptop-code',
            'short_description' => fake()->paragraph(),
            'description' => fake()->paragraphs(3, true),
            'starting_price' => fake()->numberBetween(5000, 25000),
            'order' => 0,
            'is_active' => true,
        ];
    }
}
