<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserProduct>
 */
class UserProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = UserProduct::class;
    
    public function definition(): array
    {
        return [
            'userID' => 1,
            'productID' => $this->faker->numberBetween(1, 100),
            'best_before' => $this->faker->date(),
            'stock' => $this->faker->numberBetween(1, 100),
        ];
    }
}
