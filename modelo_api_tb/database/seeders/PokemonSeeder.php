<?php

namespace Database\Seeders;

use App\Models\Pokemon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class PokemonSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Buscando os 151 Pokémon da PokeAPI...');

        for ($id = 1; $id <= 151; $id++) {
            $response = Http::get("https://pokeapi.co/api/v2/pokemon/{$id}");

            if (!$response->successful()) {
                $this->command->warn("Pokémon ID {$id} não encontrado, pulando...");
                continue;
            }

            $dados = $response->json();

            $tipo = $dados['types'][0]['type']['name'];
            $ataque = collect($dados['stats'])
                ->firstWhere('stat.name', 'attack')['base_stat'] ?? 0;
            $sprite = $dados['sprites']['front_default'];

            Pokemon::updateOrCreate(
                ['nome' => $dados['name']],
                [
                    'tipo'   => $tipo,
                    'ataque' => $ataque,
                    'sprite' => $sprite,
                ]
            );

            $this->command->line("  #{$id} {$dados['name']} adicionado.");
        }

        $this->command->info('Pokédex completa! 151 Pokémon salvos no banco.');
    }
}
