@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Estoque</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('estoque.update', $estoque->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="produto_id">ID do Produto:</label>
            <input type="number" class="form-control" id="produto_id" name="produto_id" value="{{ old('produto_id', $estoque->produto_id) }}" required>
        </div>

        <div class="form-group">
            <label for="quantidade">Quantidade:</label>
            <input type="number" class="form-control" id="quantidade" name="quantidade" value="{{ old('quantidade', $estoque->quantidade) }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Atualizar</button>
        <a href="{{ route('estoque.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection