<?php

namespace App\Http\Controllers;
use App\Models\Clientes;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function index() {
        $Clientes = Clientes::all();
        return view('clientes.index', compact('Clientes'));
    }

    public function create(){
        return view('clientes.create');
    }

    public function store(Request $request){
        $request->validate([
            'nome' => 'required|string|max:255',
            'cpf' => 'required|string|unique:clientes',
            'email' => 'required|email|unique:clientes',
            'telefone' => 'required|string',
            'endereco' => 'nullable|string',
        ]);

        Clientes::create($request->all());

        return redirect()->route('clientes.index')->with('success', 'Cliente cadastrado com sucesso!');
    }

    public function edit(Clientes $cliente){
        return view('clientes.edit', compact('cliente'));
    }

    public function update(Request $request, Clientes $cliente) {
        $request->validate([
            'nome' => 'required|string|max:255',
            'cpf' => 'required|string|unique:clientes,cpf,' . $cliente->id,
            'email' => 'required|email|unique:clientes,email,' . $cliente->id,
            'telefone' => 'required|string',
            'endereco' => 'nullable|string',
        ]);

        $cliente->update($request->all());
        return redirect()->route('clientes.index')->with('success', 'Cliente atualizado com sucesso!');
    }

    public function destroy(Clientes $cliente){
        $cliente->delete();
        return redirect()->route('clientes.index')->with('success', 'Cliente removido com sucesso!');
    }
}