<?php

namespace App\Http\Controllers;

use App\Models\Estoque;
use Illuminate\Http\Request;

class EstoqueController extends Controller
{
    public function index() {
        $Estoques = \App\Models\Estoque::all();
        return view('estoque.index', compact('Estoques'));
    }

    public function create(){
        return view('estoque.create');
    }

    public function store(Request $request){
        $request->validate([
            'produto_id' => 'required|integer',
            'quantidade' => 'required|integer',
        ]);

        Estoque::create($request->all());

        return redirect()->route('estoque.index')->with('success', 'Estoque cadastrado com sucesso!');
    }

    public function edit(Estoque $estoque){
        return view('estoque.edit', compact('estoque'));
    }

    public function update(Request $request, Estoque $estoque){
        $request->validate([
           'produto_id' => 'required|integer',
            'quantidade' => 'required|integer',
        ]);

        $estoque->update($request->all());
        return redirect()->route('estoque.index')->with('success', 'Produto atualizado com sucesso!');
    }

    public function destroy(Estoque $estoque){
        $estoque->delete();
        return redirect()->route('estoque.index')->with('success', 'Produto removido com sucesso!');
    }
}