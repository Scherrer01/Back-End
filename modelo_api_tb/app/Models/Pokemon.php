<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pokemon extends Model
{
    protected $table = 'pokemons';
    protected $fillable = ['nome', 'tipo', 'ataque', 'hp', 'defesa', 'ataque_especial', 'defesa_especial', 'velocidade', 'sprite', 'moves'];
    protected $casts = ['moves' => 'array'];
}
