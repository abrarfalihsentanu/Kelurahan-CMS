<?php

namespace Database\Factories;

use App\Models\NewsCategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\News>
 */
class NewsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->sentence();
        return [
            'news_category_id' => NewsCategory::factory(),
            'user_id' => User::factory(),
            'title' => $title,
            'slug' => Str::slug($title),
            'excerpt' => $this->faker->paragraph(),
            'content' => $this->faker->paragraphs(3, true),
            'image' => null,
            'is_featured' => $this->faker->boolean(),
            'is_published' => true,
            'published_at' => now(),
            'views' => $this->faker->numberBetween(0, 1000),
        ];
    }

    /**
     * Indicate that the news should be unpublished.
     */
    public function unpublished(): static
    {
        return $this->state(fn(array $attributes) => [
            'is_published' => false,
            'published_at' => null,
        ]);
    }

    /**
     * Indicate that the news should be featured.
     */
    public function featured(): static
    {
        return $this->state(fn(array $attributes) => [
            'is_featured' => true,
        ]);
    }
}
