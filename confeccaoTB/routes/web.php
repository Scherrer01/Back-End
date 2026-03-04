<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\DesejosController;
use App\Http\Controllers\FornecedoresController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Rotas de Clientes
Route::get('/clientes', [ClienteController::class, 'index'])->name('clientes.index');
Route::get('/clientes/create', [ClienteController::class, 'create'])->name('clientes.create');
Route::post('/clientes', [ClienteController::class, 'store'])->name('clientes.store');
Route::get('/clientes/{id}', [ClienteController::class, 'show'])->name('clientes.show');
Route::get('/clientes/{id}/edit', [ClienteController::class, 'edit'])->name('clientes.edit');
Route::put('/clientes/{id}', [ClienteController::class, 'update'])->name('clientes.update');
Route::delete('/clientes/{id}', [ClienteController::class, 'destroy'])->name('clientes.destroy');

// Rotas de Desejos
Route::get('/desejos', [DesejosController::class, 'index'])->name('desejos.index');
Route::get('/desejos/create', [DesejosController::class, 'create'])->name('desejos.create');
Route::post('/desejos', [DesejosController::class, 'store'])->name('desejos.store');
Route::get('/desejos/{id}', [DesejosController::class, 'show'])->name('desejos.show');
Route::get('/desejos/{id}/edit', [DesejosController::class, 'edit'])->name('desejos.edit');
Route::put('/desejos/{id}', [DesejosController::class, 'update'])->name('desejos.update');
Route::delete('/desejos/{id}', [DesejosController::class, 'destroy'])->name('desejos.destroy');

// Rotas de Fornecedores
Route::get('/fornecedores', [FornecedoresController::class, 'index'])->name('fornecedores.index');
Route::get('/fornecedores/create', [FornecedoresController::class, 'create'])->name('fornecedores.create');
Route::post('/fornecedores', [FornecedoresController::class, 'store'])->name('fornecedores.store');
Route::get('/fornecedores/{id}', [FornecedoresController::class, 'show'])->name('fornecedores.show');
Route::get('/fornecedores/{id}/edit', [FornecedoresController::class, 'edit'])->name('fornecedores.edit');
Route::put('/fornecedores/{id}', [FornecedoresController::class, 'update'])->name('fornecedores.update');
Route::delete('/fornecedores/{id}', [FornecedoresController::class, 'destroy'])->name('fornecedores.destroy');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';