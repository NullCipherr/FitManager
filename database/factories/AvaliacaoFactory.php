<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AvaliacaoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nota' => $this->faker->randomElement(['abaixo da média','mediano','acima da média']),
            'descr' => $this->faker->sentence(),
            'account_id' => '1',


        ];
    }
}
