<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\Transacao;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RelatorioController extends Controller
{

    public function index(Request $request)
    {
        $transacoes = Transacao::whereDate('transacoes.created_at', Carbon::today())
            ->leftjoin('projetos', 'transacoes.projeto_id', '=', 'projetos.id')
            ->selectRaw('transacoes.*, projetos.nome as projeto')
            ->orderBy('id', 'DESC')
            ->take(20)->get();

        $soma_transacoes = Transacao::whereDate('transacoes.created_at', Carbon::today())
            ->selectRaw("transacoes.*, SUM(if(transacoes.tag = 'VENDA', 1, 0)) AS total_vendas,  DATE(created_at) as date, SUM(if(transacoes.tipo = 'ENTRADA', transacoes.valor, 0)) AS entradas, SUM(if(transacoes.tipo = 'SAIDA', transacoes.valor, 0)) AS saidas")
            ->groupBy('date')
            ->first();

        return view('user.relatorio', [
            "transacoes" => $transacoes, "soma_transacoes" => $soma_transacoes
        ]);
    }

    public function search(Request $request)
    {

        $transacoes = Transacao::leftjoin('projetos', 'transacoes.projeto_id', '=', 'projetos.id')
            ->selectRaw('transacoes.*, projetos.nome as projeto')
            ->whereBetween('transacoes.created_at', [$request->data_inicio, $request->data_fim])
            ->orderBy('id', 'DESC')
            ->take(20)->get();

        $soma_transacoes = Transacao::selectRaw("transacoes.*, SUM(if(transacoes.tag = 'VENDA', 1, 0)) AS total_vendas,  DATE(created_at) as date, SUM(if(transacoes.tipo = 'ENTRADA', transacoes.valor, 0)) AS entradas, SUM(if(transacoes.tipo = 'SAIDA', transacoes.valor, 0)) AS saidas")
            ->whereBetween('transacoes.created_at', [$request->data_inicio, $request->data_fim])
            ->groupBy('date')
            ->first();

        return response()->json([
            "success" => true,
            "msg" => 'Transações listadas!',
            "transacoes" => $transacoes,
            "soma_transacoes" => $soma_transacoes
        ], Response::HTTP_OK);
    }
}
