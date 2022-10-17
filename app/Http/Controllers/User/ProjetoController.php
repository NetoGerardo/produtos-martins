<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Projeto;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProjetoController extends Controller
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

        return view('user.projetos', ['projetos' => $projetos]);
    }

    public function store(Request $request)
    {
        Projeto::create([
            'nome' => $request->nome,
            'descricao' => $request->descricao,
            'tipo_produto' => $request->tipo_produto,
        ]);

        return response()->json([
            "success" => true,
            "msg" => 'Projeto cadastrado!',
        ], Response::HTTP_OK);
    }
}
