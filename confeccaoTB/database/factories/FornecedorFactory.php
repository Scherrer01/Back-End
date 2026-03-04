<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class FornecedoresFactory extends Factory
{
    protected $model = \App\Models\Fornecedores::class;

    public function definition(): array
    {
        return [
            'nome' => fake()->company(),
            'cnpj' => fake()->numerify('##.###.###/####-##'),
            'email' => fake()->companyEmail(),
            'telefone' => fake()->phoneNumber(),
            'endereco' => fake()->streetAddress(),
            'cidade' => fake()->city(),
            'estado' => fake()->stateAbbr(),
            'responsavel' => fake()->name(),
            'observacoes' => fake()->optional()->sentence(),
        ];
    }
}