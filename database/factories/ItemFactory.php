<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->jobTitle(),
            'price' => $this->faker->randomElement(['10000', '50000']),
            'size' => $this->faker->randomElement(['S', 'M', 'L', 'XL', '2XL', 'XXL', '2XL', '3XL']),
            'color' => $this->faker->colorName(),
            'description' => $this->faker->sentence()
        ];
    }
}
