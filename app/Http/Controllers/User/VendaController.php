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

class VendaController extends Controller
{

    public function store(Request $request)
    {

        $produto = Produto::find($request->produto_id);

        if ($produto->quantidade_disponivel >= $request->quantidade) {
            $venda = Venda::create([
                'quantidade' => $request->quantidade,
                'comprador' => $request->comprador,
                'valor_venda' => $request->valor_venda,
                'produto_id' => $request->produto_id,
                'observacao' => $request->observacao,
            ]);

            $descricao = "Venda de ". $request->quantidade . " unidade(s) de " . $produto->nome;

            Transacao::create([
                'valor' => $request->valor_venda,
                'tipo' => 'ENTRADA',
                'tag' => 'Venda',
                'projeto_id' => $produto->projeto_id,
                'descricao' => $descricao,
                'venda_id' => $venda->id
            ]);

            $produto->quantidade_disponivel = $produto->quantidade_disponivel - $request->quantidade;
            $produto->quantidade_vendida = $produto->quantidade_vendida + $request->quantidade;
            $produto->save();

        } else {
            return response()->json("Quantidade indisponível!", Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return response()->json([
            "success" => true,
            "msg" => 'Venda cadastrada!',
        ], Response::HTTP_OK);
    }
}
