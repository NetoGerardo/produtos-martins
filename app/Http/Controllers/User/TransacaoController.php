<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\Produto;
use App\Models\Projeto;
use App\Models\Transacao;
use App\Models\Venda;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TransacaoController extends Controller
{

    public function store(Request $request)
    {

        Transacao::create([
            'valor' => $request->valor,
            'tipo' => $request->tipo,
            'tag' => $request->tag,
            'projeto_id' => $request->projeto_id,
            'transacao_paga' => 1,
            'descricao' => $request->descricao,
        ]);

        return response()->json([
            "success" => true,
            "msg" => 'Transação cadastrada!',
        ], Response::HTTP_OK);
    }
}
