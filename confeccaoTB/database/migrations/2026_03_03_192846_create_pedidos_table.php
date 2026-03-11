<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('cliente_id')
                  ->constrained('clientes')
                  ->onDelete('cascade');

            // CORREÇÃO 1: Nome do campo no padrão (singular)
            // $table->foreignId('produto_id')
            //       // CORREÇÃO 2: Nome da tabela é 'estoques' (plural), não 'estoque'
            //       ->constrained('estoques')  
            //       ->onDelete('cascade');

            $table->integer('quantidade');
            $table->decimal('valor_total', 10, 2);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};