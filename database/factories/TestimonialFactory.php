<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Testimonial;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Testimonial>
 */
class TestimonialFactory extends Factory
{
    protected $model = Testimonial::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'designation' => fake()->jobTitle(),
            'image' => 'assets/front/img/17362348801814731466.png',
            'comment' => fake()->paragraph(),
            'rating' => 5,
            'order' => fake()->numberBetween(0, 10),
            'is_active' => true,
        ];
    }
}
