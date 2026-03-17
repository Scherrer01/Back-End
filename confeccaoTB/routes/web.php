<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\EstoqueController;
use App\Http\Controllers\FornecedoresController;
use App\Http\Controllers\PedidosController;
use App\Http\Controllers\ProdutosController;

Route::get('/', function () {
    return view('welcome');
});

// Rotas protegidas (requerem login)
Route::middleware(['auth'])->group(function () {
    
    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    
    // Clientes
    Route::get('/clientes', [ClienteController::class, 'index'])->name('clientes.index');
    Route::get('/clientes/create', [ClienteController::class, 'create'])->name('cliente.create');
    Route::post('/clientes', [ClienteController::class, 'store'])->name('clientes.store');
    Route::get('/clientes/{cliente}/edit', [ClienteController::class, 'edit'])->name('clientes.edit');
    Route::put('/clientes/{cliente}', [ClienteController::class, 'update'])->name('clientes.update');
    Route::delete('/clientes/{cliente}', [ClienteController::class, 'destroy'])->name('clientes.destroy');
    
    // Produtos
    Route::get('/produtos', [ProdutosController::class, 'index'])->name('produtos.index');
    Route::get('/produtos/create', [ProdutosController::class, 'create'])->name('produtos.create');
    Route::post('/produtos', [ProdutosController::class, 'store'])->name('produtos.store');
    Route::get('/produtos/{produto}/edit', [ProdutosController::class, 'edit'])->name('produtos.edit');
    Route::put('/produtos/{produto}', [ProdutosController::class, 'update'])->name('produtos.update');
    Route::delete('/produtos/{produto}', [ProdutosController::class, 'destroy'])->name('produtos.destroy');
    
    // Fornecedores
    Route::get('/fornecedores', [FornecedoresController::class, 'index'])->name('fornecedores.index');
    Route::get('/fornecedores/create', [FornecedoresController::class, 'create'])->name('fornecedores.create');
    Route::post('/fornecedores', [FornecedoresController::class, 'store'])->name('fornecedores.store');
    Route::get('/fornecedores/{fornecedor}/edit', [FornecedoresController::class, 'edit'])->name('fornecedores.edit');
    Route::put('/fornecedores/{fornecedor}', [FornecedoresController::class, 'update'])->name('fornecedores.update');
    Route::delete('/fornecedores/{fornecedor}', [FornecedoresController::class, 'destroy'])->name('fornecedores.destroy');
    
    // Pedidos
    Route::get('/pedidos', [PedidosController::class, 'index'])->name('pedidos.index');
    Route::get('/pedidos/create', [PedidosController::class, 'create'])->name('pedidos.create');
    Route::post('/pedidos', [PedidosController::class, 'store'])->name('pedidos.store');
    Route::get('/pedidos/{pedido}/edit', [PedidosController::class, 'edit'])->name('pedidos.edit');
    Route::put('/pedidos/{pedido}', [PedidosController::class, 'update'])->name('pedidos.update');
    Route::delete('/pedidos/{pedido}', [PedidosController::class, 'destroy'])->name('pedidos.destroy');
    
    // Estoque
    Route::get('/estoque', [EstoqueController::class, 'index'])->name('estoque.index');
    Route::get('/estoques/create', [EstoqueController::class, 'create'])->name('estoques.create');
    Route::post('/estoques', [EstoqueController::class, 'store'])->name('estoques.store');
    Route::get('/estoques/{estoque}/edit', [EstoqueController::class, 'edit'])->name('estoques.edit');
    Route::put('/estoques/{estoque}', [EstoqueController::class, 'update'])->name('estoques.update');
    Route::delete('/estoques/{estoque}', [EstoqueController::class, 'destroy'])->name('estoques.destroy');
    
    // Profile (já estava protegido)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';