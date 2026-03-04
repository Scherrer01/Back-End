<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DesejosFactory extends Factory
{
    public function definition(): array
    {
        return [
            'cliente_id' => fake()->numberBetween(1, 10),
            'produto' => fake()->word(),
            'quantidade' => fake()->numberBetween(1, 5),
            'valor' => fake()->randomFloat(2, 20, 500),
            'status' => fake()->randomElement(['pendente', 'em_andamento', 'concluido']),
        ];
    }
}