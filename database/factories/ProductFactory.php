<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

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
            'id' => fake()->uuid(),
            'name' => fake()->lastName(),
            'description' => fake()->paragraph(),
            'price' => fake()->numberBetween(1000, 100000),
            'stock' => fake()->numberBetween(0, 100)
        ];
    }
}
