<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Container;
use App\Models\Lista;
use Illuminate\Http\Response;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ListasController extends Controller
{
    public function index()
    {
        $listas = Lista::all();

        return view('admin.listas.create', [
            "listas" => $listas
        ]);
    }

    protected function store(Request $request)
    {

        Log::info("Chegou no create!!");

        $lista = Lista::whereNome($request->nome)->exists();

        if ($lista) {
            return response()->json("Lista já cadastrada!", Response::HTTP_UNPROCESSABLE_ENTITY);
        } else {
            $lista = Lista::create([
                'nome' => $request->nome,
            ]);

            Log::info($lista);

            return response()->json([
                "success" => true,
                "msg" => 'Lista criada!',
            ], Response::HTTP_OK);
        }
    }

    protected function update(Request $request)
    {

        $lista = Lista::where('id', '=', $request->id)->first();

        $lista->nome = $request->nome;

        $lista->save();

        return response()->json([
            "success" => true,
            "msg" => 'Lista atualizada!',
        ], Response::HTTP_OK);
    }

    protected function delete(Request $request)
    {

        $lista = Lista::find($request->id);
        $lista->delete();

        return response()->json([
            "success" => true,
            "msg" => 'Lista deletada!',
        ], Response::HTTP_OK);
    }
}
