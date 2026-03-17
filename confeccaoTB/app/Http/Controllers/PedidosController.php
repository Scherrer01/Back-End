<?php

namespace App\Http\Controllers;

use App\Models\Pedidos;
use Illuminate\Http\Request;

class PedidosController extends Controller
{
    public function index() {
        $pedidos = Pedidos::all();
        return view('pedidos.index', compact('pedidos'));
    }

    public function create(){
        return view('pedidos.create');
    }

    public function store(Request $request){
        $request->validate([
            'cliente_id' => 'required|integer',
            'produto_id' => 'required|integer',
            'quantidade' => 'required|integer',
            'valor_total' => 'required|numeric',
        ]);

        Pedidos::create($request->all());

        return redirect()->route('pedidos.index')->with('success', 'Pedido cadastrado com sucesso!');
    }

    public function edit(Pedidos $pedido){
        return view('pedidos.edit', compact('pedido')); // ← CORRIGIDO
    }

    public function update(Request $request, Pedidos $pedido){
        $request->validate([
            'cliente_id' => 'required|integer',
            'produto_id' => 'required|integer',
            'quantidade' => 'required|integer',
            'valor_total' => 'required|numeric',
        ]);

        $pedido->update($request->all());
        
        return redirect()->route('pedidos.index')->with('success', 'Pedido atualizado com sucesso!');
    }

    public function destroy(Pedidos $pedido){
        $pedido->delete();
        return redirect()->route('pedidos.index')->with('success', 'Pedido removido com sucesso!');
    }
}