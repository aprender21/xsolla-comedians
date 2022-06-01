<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ComedianFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'description' => $this->faker->text(50),
            'code' => $this->faker->numerify('#####'),
            'status' => $this->faker->randomElement(['active', 'inactive']),
        ];
    }
}
