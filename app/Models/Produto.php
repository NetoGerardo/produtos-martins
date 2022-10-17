<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Produto extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nome',
        'quantidade',
        'quantidade_disponivel',
        'vendida',
        'valor_compra',
        'valor_venda',
        'projeto_id',
        'categoria_id',
    ];
}
