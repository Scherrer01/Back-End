<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Estoque>
 */
class EstoqueFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
         return [
            'produto' => fake()->text(),
            'quantidade' => fake()->numberBetween(1, 100),
            'preco' => fake()->randomFloat(2, 5, 500),
            'fornecedor_id' => fake()->numberBetween(1, 10),
        ];
    }
}
