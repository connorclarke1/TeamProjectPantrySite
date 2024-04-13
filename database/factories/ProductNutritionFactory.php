<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductNutritionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $productId = 0;

        return [
            'productID' => ++$productId,
            'calories' => rand(0,700),
            'protein' => rand(0,80),
            'carbs' => rand(0,80),
            'fat' => rand(0,50),
        ];
    }
}
