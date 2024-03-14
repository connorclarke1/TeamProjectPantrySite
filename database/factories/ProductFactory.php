<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'category' => 'Book',
            'artist' => fake()->name(),
            'title' => fake()->name(),
            'price' => rand(0,1000),
            'image' => '1704238410_download.jfif',
            'creator' => 2,
        ];
    }
}
