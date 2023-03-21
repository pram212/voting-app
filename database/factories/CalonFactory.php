<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CalonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'keterangan' => $this->faker->name(),
            'no_urut' => $this->faker->unique()->numberBetween(1,5)
        ];
    }
}
