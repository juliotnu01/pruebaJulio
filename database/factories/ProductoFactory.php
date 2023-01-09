<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "producto" => $this->faker->sentence($nbWords = 2, $variableNbWords = true),
            "precio" => $this->faker->numberBetween($min = 10000, $max = 99999),
            "impuesto" => $this->faker->numberBetween($min = 5, $max = 15) 
        ];
    }
}
