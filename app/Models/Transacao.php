<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transacao extends Model
{
    protected $table = 'transacoes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'valor',
        'tipo',
        'projeto_id',
        'tag',
        'descricao',
        'venda_id',
        'data_vencimento',
        'transacao_paga'
    ];
}
