<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Container;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class   UsersController extends Controller
{
    public function list(Request $request)
    {

        if ($request->search) {
            $usuarios = User::where('id', '>', 1)
                ->where('name', 'LIKE', "%" . $request->search . "%")
                ->orWhere('email', 'LIKE', "%" . $request->search . "%")
                ->orderBy('id', 'DESC')->get();
        } else {
            $usuarios = User::where('id', '>', 1)->orderBy('id', 'DESC')->get();
        }

        $usuarios_formatados = $usuarios->map(function ($usuario) {
            return [
                "usuario" => $usuario,
                "roles" => $usuario->roles
            ];
        });

        return view('admin.users.list', [
            "usuarios" => $usuarios_formatados,
        ]);
    }

    protected function searchByRole(Request $request)
    {
        if ($request->role) {
            $role = $request->role;

            $usuarios = User::whereHas(
                'roles',
                function ($q) use ($role) {
                    $q->where('name', $role);
                }
            );
        } else {
            $usuarios = User::where('id', '>', 1)->orderBy('id', 'DESC');
        }

        if ($request->nome != '') {
            $usuarios = $usuarios->where('name', 'LIKE', "%" . $request->nome . "%")
                ->orWhere('email', 'LIKE', "%" . $request->nome . "%");
        }

        $usuarios = $usuarios->get();

        $usuarios_formatados = $usuarios->map(function ($usuario) {
            return [
                "usuario" => $usuario,
                "roles" => $usuario->roles
            ];
        });

        return response()->json([
            "success" => true,
            "msg" => 'Usuáris listados!',
            "usuarios" => $usuarios_formatados
        ], Response::HTTP_OK);
    }

    public function delete(Request $request)
    {
        Log::info("Id - " . $request->user_id);

        $usuario = User::find($request->user_id);
        $usuario->delete();

        return response()->json([
            "success" => true,
            "msg" => 'Usuário deletado!',
        ], Response::HTTP_OK);
    }

    public function newcreate(Request $request)
    {

        if ($request->search) {
            $usuarios = User::where('id', '>', 1)
                ->where('name', 'LIKE', "%" . $request->search . "%")
                ->orderBy('id', 'DESC')->get();
        } else {
            $usuarios = User::where('id', '>', 1)->orderBy('id', 'DESC')->get();
        }

        $usuarios_formatados = $usuarios->map(function ($usuario) {
            return [
                "usuario" => $usuario,
                "roles" => $usuario->roles
            ];
        });

        return view('admin.users.only-list', [
            "usuarios" => $usuarios_formatados,
        ]);
    }

    protected function store(Request $request)
    {

        $user = User::whereEmail($request->email)->exists();

        if ($user) {
            return response()->json("Email já cadastrado!", Response::HTTP_UNPROCESSABLE_ENTITY);
        } else {
            $user = User::create([
                'name' => $request->nome,
                'email' => $request->email,
                'password' => Hash::make($request->senha),
            ]);

            $role = Role::findByName("user");
            $user->assignRole($role);

            return response()->json([
                "success" => true,
                "msg" => 'Usuário criado!',
            ], Response::HTTP_OK);
        }
    }

    protected function update(Request $request)
    {

        $user = User::find($request->user_id);

        if ($request->senha != "") {
            $user->password = Hash::make($request->senha);
            $user->altera_senha = "1";
        }

        $user->name = $request->nome;
        $user->email = $request->email;
        $user->save();

        return response()->json([
            "success" => true,
            "msg" => 'Usuário atualizado!',
        ], Response::HTTP_OK);
    }
}
