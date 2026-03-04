<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Clientes;
use App\Models\Desejos;
use App\Models\Fornecedores;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;
        
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Criar 5 clientes
        // Clientes::factory(5)->create();
        Clientes::factory(10)->create();

        // Criar 10 pedidos
        Desejos::factory(10)->create();


    // ... outros seeders que você já tem
        Fornecedores::factory(5)->create();

        // Criar usuário de teste
    //     User::factory()->create([
    //         'name' => 'Test User',
    //         'email' => 'test@example.com',
    //     ]);
     }
}