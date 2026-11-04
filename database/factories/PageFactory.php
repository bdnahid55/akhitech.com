<?php

namespace Database\Factories;

use App\Models\Page;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Page>
 */
class PageFactory extends Factory
{
    protected $model = Page::class;

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
            'content' => fake()->paragraphs(3, true),
            'show_in_header' => false,
            'header_parent_id' => null,
            'show_in_footer' => false,
            'footer_column' => 'quick_links',
            'order' => 0,
            'is_active' => true,
            'meta_title' => $title,
            'meta_description' => fake()->paragraph(),
            'meta_keywords' => 'laravel, web development, it',
        ];
    }
}
