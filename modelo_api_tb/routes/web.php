<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

// GET: Buscar todos os usuários
Route::get('usuarios', function () {
    $response = Http::get("https://dummyjson.com/users");
    
    if ($response->successful()) {
        $dados = $response->json();
        
        // Simplificando os dados para retornar apenas informações principais
        $usuarios = array_map(function($user) {
            return [
                'id' => $user['id'],
                'nome_completo' => $user['firstName'] . ' ' . $user['lastName'],
                'email' => $user['email'],
                'idade' => $user['age'],
                'genero' => $user['gender'],
                'foto' => $user['image']
            ];
        }, $dados['users']);
        
        return response()->json([
            'status' => 'Conectado com sucesso!',
            'total_usuarios' => $dados['total'],
            'usuarios' => $usuarios
        ], 200);
    }
    
    return response()->json(['erro' => 'Não foi possível buscar os usuários'], 500);
});

// GET: Buscar usuário específico por ID
Route::get('usuario/{id}', function ($id) {
    $response = Http::get("https://dummyjson.com/users/{$id}");
    
    if ($response->successful()) {
        $user = $response->json();
        
        return response()->json([
            'status' => 'Usuário encontrado!',
            'usuario' => [
                'id' => $user['id'],
                'nome' => $user['firstName'],
                'sobrenome' => $user['lastName'],
                'nome_completo' => $user['firstName'] . ' ' . $user['lastName'],
                'email' => $user['email'],
                'telefone' => $user['phone'],
                'idade' => $user['age'],
                'genero' => $user['gender'],
                'data_nascimento' => $user['birthDate'],
                'foto' => $user['image'],
                'endereco' => $user['address']['address'] . ', ' . $user['address']['city'] . ' - ' . $user['address']['country']
            ]
        ], 200);
    }
    
    return response()->json(['erro' => 'Usuário não encontrado'], 404);
});

// POST: Cadastrar novo usuário
Route::post('usuario/novo', function (Request $request) {
    // Validando os dados recebidos
    $dados = $request->validate([
        'firstName' => 'required|string|min:2|max:50',
        'lastName' => 'required|string|min:2|max:50',
        'email' => 'required|email',
        'age' => 'required|integer|min:0|max:150',
        'gender' => 'required|in:male,female',
        'phone' => 'required|string',
        'birthDate' => 'required|date',
        'address' => 'required|array',
        'address.address' => 'required|string',
        'address.city' => 'required|string',
        'address.country' => 'required|string'
    ]);
    
    // Simulando o cadastro (API fake não persiste dados)
    $novoId = rand(1000, 9999);
    
    return response()->json([
        'mensagem' => 'Usuário cadastrado com sucesso!',
        'status' => 'success',
        'id_gerado' => $novoId,
        'dados_enviados' => $dados,
        'observacao' => 'Como é uma API fake (dummyjson.com), os dados não são realmente persistidos. Em produção, você salvaria no banco de dados.'
    ], 201);
});

// GET: Buscar usuários por filtros (exemplo: por nome)
Route::get('usuarios/buscar', function (Request $request) {
    $nome = $request->query('nome');
    
    if (!$nome) {
        return response()->json(['erro' => 'Parâmetro "nome" é obrigatório'], 400);
    }
    
    $response = Http::get("https://dummyjson.com/users/search?q={$nome}");
    
    if ($response->successful()) {
        $dados = $response->json();
        
        $usuarios = array_map(function($user) {
            return [
                'id' => $user['id'],
                'nome_completo' => $user['firstName'] . ' ' . $user['lastName'],
                'email' => $user['email']
            ];
        }, $dados['users']);
        
        return response()->json([
            'status' => 'Busca realizada com sucesso!',
            'total_encontrados' => $dados['total'],
            'usuarios' => $usuarios
        ], 200);
    }
    
    return response()->json(['erro' => 'Erro na busca'], 500);
});

// Rota principal
Route::get('/', function () {
    return view('welcome');
});