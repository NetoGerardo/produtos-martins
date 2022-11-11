<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Projeto;
use App\Models\Transacao;
use App\Models\TransacaoRecorrente;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TransacaoRecorrenteController extends Controller
{

    public function all(Request $request)
    {
        $projetos = Projeto::all();

        return response()->json([
            "success" => true,
            "msg" => 'Projetos listados!',
            "projetos" => $projetos
        ], Response::HTTP_OK);
    }

    public function index(Request $request)
    {

        $projetos = Projeto::all();

        $transacoes_recorrentes = TransacaoRecorrente::all();

        return view('user.transacoes_recorrentes.index', ['transacoes_recorrentes' => $transacoes_recorrentes, "projetos" => $projetos]);
    }

    public function store(Request $request)
    {
        TransacaoRecorrente::create([
            'nome' => $request->nome,
            'valor' => $request->valor,
            'tipo' => $request->tipo,
            'projeto_id' => $request->projeto_id,
            'descricao' => $request->descricao,
            'periodo' => $request->periodo,
            'dia_do_mes' => $request->dia_do_mes,
            'data_proxima_transacao' => $request->data_proxima_transacao,
            'data_primeira_transacao' => $request->data_primeira_transacao
        ]);

        Transacao::create([
            'valor' => $request->valor,
            'tipo' => $request->tipo,
            'tag' => $request->tag,
            'projeto_id' => $request->projeto_id,
            'descricao' => $request->descricao,
            'data_vencimento' => $request->data_primeira_transacao,
        ]);

        return response()->json([
            "success" => true,
            "msg" => 'Transação recorrente cadastrada!',
        ], Response::HTTP_OK);
    }

    protected function update(Request $request)
    {

        $transacao_recorrente = TransacaoRecorrente::find($request->id);
        $transacao_recorrente->nome = $request->nome;
        $transacao_recorrente->descricao = $request->descricao;
        $transacao_recorrente->valor = $request->valor;
        $transacao_recorrente->tag = $request->tag;
        $transacao_recorrente->save();

        return response()->json([
            "success" => true,
            "msg" => 'Transação atuaizada!',
        ], Response::HTTP_OK);
    }

    protected function delete(Request $request)
    {

        TransacaoRecorrente::find($request->transacao_recorrente_id)->delete();

        return response()->json([
            "success" => true,
            "msg" => 'Transação deletada!',
        ], Response::HTTP_OK);
    }
}
