<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pedidos>
 */
class PedidosFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'cliente_id' => fake()->numberBetween(1, 10),
            'produto_id' => fake()->numberBetween(1, 10),
            'quantidade' => fake()->numberBetween(1, 50),
            'valor_total' => fake()->randomFloat(2, 10, 1000),
        ];
    }
}
