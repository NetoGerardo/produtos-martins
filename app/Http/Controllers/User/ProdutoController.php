<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\Produto;
use App\Models\Projeto;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProdutoController extends Controller
{

    public function index(Request $request)
    {

        $produtos = Produto::all();
        $categorias = Categoria::all();
        $projetos = Projeto::all();

        return view('user.produtos', [
            'produtos' => $produtos,
            'categorias' => $categorias,
            'projetos' => $projetos
        ]);
    }

    public function all(Request $request)
    {
        $produtos = Produto::all();

        return response()->json([
            "success" => true,
            "msg" => 'Produtos listados!',
            "produtos" => $produtos
        ], Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        Produto::create([
            'nome' => $request->nome,
            'quantidade' => $request->quantidade,
            'quantidade_disponivel' => $request->quantidade,
            'valor_compra' => $request->valor_compra,
            'valor_venda' => $request->valor_venda,
            'projeto_id' => $request->projeto_id,
            'categoria_id' => $request->categoria_id,
        ]);

        return response()->json([
            "success" => true,
            "msg" => 'Projeto cadastrado!',
        ], Response::HTTP_OK);
    }
}
