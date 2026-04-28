<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class UsuariosController extends Controller
{
    public function index() {
        $id = rand(1, 100);
        $response = Http::get("https://dummyjson.com/users/{$id}");

        if ($response->successful()) {
            $usuario = $response->json();

            return view('usuarios', compact('usuario'));
        }
        return "Erro ao buscar dados da API";
    }
}