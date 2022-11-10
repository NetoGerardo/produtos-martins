<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransacaoRecorrente extends Model
{
    protected $table = 'transacoes_recorrentes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nome',
        'valor',
        'tipo',
        'projeto_id',
        'tag',
        'descricao',
        'periodo',
        'dia_do_mes',
        'dia_da_semana',
        'data_primeira_transacao',
        'data_proxima_transacao',
    ];
}
