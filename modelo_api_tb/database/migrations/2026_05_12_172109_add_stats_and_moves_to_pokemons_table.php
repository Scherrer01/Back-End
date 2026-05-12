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
        Schema::table('pokemons', function (Blueprint $table) {
            $table->integer('hp')->default(50)->after('ataque');
            $table->integer('defesa')->default(50)->after('hp');
            $table->integer('ataque_especial')->default(50)->after('defesa');
            $table->integer('defesa_especial')->default(50)->after('ataque_especial');
            $table->integer('velocidade')->default(50)->after('defesa_especial');
            $table->json('moves')->nullable()->after('velocidade');
        });
    }

    public function down(): void
    {
        Schema::table('pokemons', function (Blueprint $table) {
            $table->dropColumn(['hp', 'defesa', 'ataque_especial', 'defesa_especial', 'velocidade', 'moves']);
        });
    }
};
