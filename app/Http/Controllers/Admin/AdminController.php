<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Container;
use App\Models\Envio;
use App\Models\Lead;
use App\Models\Mensagem;
use App\Models\Transacao;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    public function index()
    {
        $ultimas_transacoes = Transacao::leftjoin('projetos', 'transacoes.projeto_id', '=', 'projetos.id')
            ->selectRaw('transacoes.*, projetos.nome as projeto')
            ->orderBy('id', 'DESC')
            ->take(20)->get();

        $total_transacoes = Transacao::selectRaw("transacoes.*, DATE(created_at) as date, SUM(if(transacoes.tipo = 'ENTRADA', transacoes.valor, 0)) AS entradas, SUM(if(transacoes.tipo = 'SAIDA', transacoes.valor, 0)) AS saidas")
            ->groupBy('date')
            ->first();

        $total_transacoes_hoje = Transacao::whereDate('transacoes.created_at', Carbon::today())
            ->selectRaw("transacoes.*, SUM(if(transacoes.tag = 'VENDA', 1, 0)) AS total_vendas,  DATE(created_at) as date, SUM(if(transacoes.tipo = 'ENTRADA', transacoes.valor, 0)) AS entradas, SUM(if(transacoes.tipo = 'SAIDA', transacoes.valor, 0)) AS saidas")
            ->groupBy('date')
            ->first();

        return view('user.index', ["ultimas_transacoes" => $ultimas_transacoes, "transacoes" => $total_transacoes, "transacoes_hoje" => $total_transacoes_hoje]);
    }
}
