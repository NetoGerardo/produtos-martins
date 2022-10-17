<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CategoriaController extends Controller
{

    public function index(Request $request)
    {

        $categorias = Categoria::all();

        return view('user.categorias', ['categorias' => $categorias]);
    }

    public function store(Request $request)
    {
        Categoria::create([
            'nome' => $request->nome,
        ]);

        return response()->json([
            "success" => true,
            "msg" => 'Categoria cadastrada!',
        ], Response::HTTP_OK);
    }
}
