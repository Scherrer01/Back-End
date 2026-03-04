<?php

namespace App\Http\Controllers;

use App\Models\Desejos;  // Model no plural
use App\Models\Clientes; // Model no plural
use Illuminate\Http\Request;

class DesejosController extends Controller
{
    public function index()
    {
        $desejos = Desejos::with('cliente')->get();
        return view('desejos.index', compact('desejos'));
    }

    public function create()
    {
        $clientes = Clientes::all();
        return view('desejos.create', compact('clientes'));
    }

    public function store(Request $request)
    {
        $desejo = new Desejos();
        $desejo->cliente_id = $request->cliente_id;
        $desejo->produto = $request->produto;
        $desejo->quantidade = $request->quantidade;
        $desejo->valor = $request->valor;
        $desejo->status = $request->status;
        $desejo->save();

        return redirect('/desejos');
    }

    public function show($id)
    {
        $desejo = Desejos::with('cliente')->find($id);
        return view('desejos.show', compact('desejo'));
    }

    public function edit($id)
    {
        $desejo = Desejos::find($id);
        $clientes = Clientes::all();
        return view('desejos.edit', compact('desejo', 'clientes'));
    }

    public function update(Request $request, $id)
    {
        $desejo = Desejos::find($id);
        $desejo->cliente_id = $request->cliente_id;
        $desejo->produto = $request->produto;
        $desejo->quantidade = $request->quantidade;
        $desejo->valor = $request->valor;
        $desejo->status = $request->status;
        $desejo->save();

        return redirect('/desejos');
    }

    public function destroy($id)
    {
        $desejo = Desejos::find($id);
        $desejo->delete();

        return redirect('/desejos');
    }
}