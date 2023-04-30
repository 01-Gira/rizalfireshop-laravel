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
            'name' => $this->faker->userName(),
            'slug' => $this->faker->slug(),
            'description' => $this->faker->sentence(),
            'stock' => 10,
            'price' => $this->faker->numberBetween(100000, 3000000),
            'category_id' => mt_rand(1,3),
            'weight' => 200,
        ];
    }
}
