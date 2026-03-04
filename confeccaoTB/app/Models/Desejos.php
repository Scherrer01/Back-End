<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Desejos extends Model
{
    use HasFactory;

    protected $fillable = [
        'cliente_id',
        'produto',
        'quantidade',
        'valor',
        'status'
    ];

    public function cliente()
    {
        return $this->belongsTo(Clientes::class);
    }
}