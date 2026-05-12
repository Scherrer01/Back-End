<?php

use App\Http\Controllers\PokemonController;
use App\Models\Pokemon;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

route::get('pokedex', [PokemonController::class, 'index']);

// Busca Pokémon no banco local (deve vir antes do wildcard {nome})
Route::get('pokemon/local/{nome}', function ($nome) {
    $pokemon = Pokemon::whereRaw('LOWER(nome) = ?', [strtolower($nome)])->first();
    if (!$pokemon) {
        return response()->json(['erro' => 'Pokémon não encontrado no banco local'], 404);
    }
    return response()->json($pokemon);
});

//Exemplo 1: GET
Route::get('pokemon/{nome}', function ($nome) {
    $response = Http::get("https://pokeapi.co/api/v2/pokemon/{$nome}");

    if ($response->successful()) {
        $dados = $response->json();
        return response()->json([
            'status' => 'Conectado com sucesso!',
            'resultado' => [
                'identificador' => $dados['id'],
                'nome_do_pokemon' => ucfirst($dados['name']),
                'foto' => $dados['sprites']['front_default']
            ]
        ], 200);
    }
    return response()->json(['erro' => 'Pokemon não encontrado'], 404);
});

// Exemplo 2: POST
Route::post('pokemon/novo', function (Request $request) {
    $dados = $request->validate([
        'nome'            => 'required|string|min:3|unique:pokemons,nome',
        'tipo'            => 'required|string',
        'ataque'          => 'required|integer|min:1|max:999',
        'hp'              => 'required|integer|min:1|max:999',
        'defesa'          => 'required|integer|min:1|max:999',
        'ataque_especial' => 'required|integer|min:1|max:999',
        'defesa_especial' => 'required|integer|min:1|max:999',
        'velocidade'      => 'required|integer|min:1|max:999',
        'sprite'          => 'nullable|string',
        'moves'           => 'nullable|array',
        'moves.*.nome'    => 'required|string',
        'moves.*.tipo'    => 'required|string',
    ]);

    $pokemon = Pokemon::create($dados);

    return response()->json([
        'mensagem'        => 'Pokemon cadastrado com sucesso!',
        'dados_salvos'    => $pokemon,
    ], 201);
});

Route::get('/', function () {
    return view('welcome');
});
