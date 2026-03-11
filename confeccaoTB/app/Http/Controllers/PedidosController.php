<?php

namespace App\Http\Controllers;

use App\Models\Pedidos;
use Illuminate\Http\Request;

class PedidosController extends Controller
{
    public function index() {
        $Pedidos = \App\Models\Pedidos::all();
        return view('pedidos.index', compact('Pedidos'));
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
}