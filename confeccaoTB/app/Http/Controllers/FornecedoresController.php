<?php

namespace App\Http\Controllers;

use App\Models\Fornecedores;
use Illuminate\Http\Request;

class FornecedoresController extends Controller
{
    public function index() {
        $fornecedores = Fornecedores::all(); // ← mudei para minúsculo (padrão)
        return view('fornecedores.index', compact('fornecedores'));
    }

    public function create(){
        return view('fornecedores.create');
    }

    public function store(Request $request){
        $request->validate([
            'nome' => 'required|string|max:255',
            'cnpj' => 'required|string|unique:fornecedores',
            'email' => 'required|email|unique:fornecedores',
            'telefone' => 'required|string',
            'endereco' => 'nullable|string',
        ]);

        Fornecedores::create($request->all());

        return redirect()->route('fornecedores.index')
            ->with('success', 'Fornecedor cadastrado com sucesso!');
    }
    
    public function edit(Fornecedores $fornecedor){ // ← mudei o nome do parâmetro para singular
        return view('fornecedores.edit', compact('fornecedor')); // ← mudei a view e a variável
    }

    public function update(Request $request, Fornecedores $fornecedor){ // ← mudei para singular
        $request->validate([
            'nome' => 'required|string|max:255',
            'cnpj' => 'required|string|unique:fornecedores,cnpj,' . $fornecedor->id, // ← adicionei a vírgula
            'email' => 'required|email|unique:fornecedores,email,' . $fornecedor->id, // ← adicionei a vírgula
            'telefone' => 'required|string',
            'endereco' => 'nullable|string',
        ]);

        $fornecedor->update($request->all()); // ← mudei para singular
        
        return redirect()->route('fornecedores.index')
            ->with('success', 'Fornecedor atualizado com sucesso!');
    }

    public function destroy(Fornecedores $fornecedor){ // ← mudei para singular
        $fornecedor->delete(); // ← mudei para singular
        return redirect()->route('fornecedores.index')
            ->with('success', 'Fornecedor removido com sucesso!');
    }
}