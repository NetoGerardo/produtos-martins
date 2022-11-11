<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Projeto;
use App\Models\Transacao;
use App\Models\TransacaoRecorrente;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TransacoesAguardandoController extends Controller
{

    public function index(Request $request)
    {

        $projetos = Projeto::all();

        $transacoes = Transacao::where("transacao_paga", "=", 0)
            ->orderBy('data_vencimento')
            ->get();

        $soma_transacoes = Transacao::where("transacao_paga", "=", 0)
            ->selectRaw("transacoes.*, SUM(if(transacoes.tipo = 'ENTRADA', transacoes.valor, 0)) AS entradas, SUM(if(transacoes.tipo = 'SAIDA', transacoes.valor, 0)) AS saidas")
            ->first();

        return view('user.transacoes.agardando_pagamento', ['transacoes' => $transacoes, "projetos" => $projetos, "soma_transacoes" => $soma_transacoes]);
    }

    public function search(Request $request)
    {

        $transacoes = Transacao::leftjoin('projetos', 'transacoes.projeto_id', '=', 'projetos.id')
            ->selectRaw('transacoes.*, projetos.nome as projeto');

        if ($request->projeto_id != "") {
            $transacoes = $transacoes->where("projeto_id", "=", $request->projeto_id);
        }

        if ($request->produto_id != "") {
            $transacoes = $transacoes->leftjoin('vendas', 'transacoes.venda_id', '=', 'vendas.id')
                ->where("vendas.produto_id", "=", $request->produto_id);
        }

        $transacoes = $transacoes->whereBetween('transacoes.data_vencimento', [$request->data_inicio, $request->data_fim])
            ->where('transacoes.transacao_paga', '=', '0')
            ->orderBy('data_vencimento')
            ->get();

        $soma_transacoes = Transacao::selectRaw("transacoes.*, SUM(if(transacoes.tag = 'VENDA', 1, 0)) AS total_vendas,  DATE(transacoes.data_vencimento) as date, SUM(if(transacoes.tipo = 'ENTRADA', transacoes.valor, 0)) AS entradas, SUM(if(transacoes.tipo = 'SAIDA', transacoes.valor, 0)) AS saidas");

        if ($request->projeto_id != "") {
            $soma_transacoes = $soma_transacoes->where("projeto_id", "=", $request->projeto_id);
        }

        if ($request->produto_id != "") {
            $soma_transacoes = $soma_transacoes->leftjoin('vendas', 'transacoes.venda_id', '=', 'vendas.id')
                ->where("produto_id", "=", $request->produto_id);
        }

        $soma_transacoes = $soma_transacoes->whereBetween('transacoes.data_vencimento', [$request->data_inicio, $request->data_fim])
            ->where('transacoes.transacao_paga', '=', '0')
            ->groupBy('date')
            ->first();

        return response()->json([
            "success" => true,
            "msg" => 'Transações listadas!',
            "transacoes" => $transacoes,
            "soma_transacoes" => $soma_transacoes
        ], Response::HTTP_OK);
    }

    protected function delete(Request $request)
    {

        Transacao::find($request->transacao_id)->delete();

        return response()->json([
            "success" => true,
            "msg" => 'Transação deletada!',
        ], Response::HTTP_OK);
    }


    protected function confirmar(Request $request)
    {

        $transacao = Transacao::find($request->transacao_id);
        $transacao->transacao_paga = 1;
        $transacao->created_at = $request->data_pagamento;
        $transacao->save();

        return response()->json([
            "success" => true,
            "msg" => 'Pagamento confirmando!',
        ], Response::HTTP_OK);
    }
}
