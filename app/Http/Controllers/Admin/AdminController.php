<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Container;
use App\Models\Envio;
use App\Models\Lead;
use App\Models\Mensagem;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    public function index()
    {

        $leads = Lead::whereNull('user_id')->get();

        $container = Container::whereUserId(Auth::user()->id)->first();

        $leads_recebidos = Lead::whereDate('created_at', Carbon::today())->where('origem_lead', '!=', 'CADASTRO MANUAL')->count();
        $leads_hoje = Lead::whereDate('created_at', Carbon::today())->count();
        $positivos = Lead::whereDate('created_at', Carbon::today())->whereAvaliacao('POSITIVA')->count();
        $negativos = Lead::whereDate('created_at', Carbon::today())->whereAvaliacao('NEGATIVA')->count();

        $total_usuarios = Container::all()->count();

        $corretores = User::whereHas(
            'roles',
            function ($q) {
                $q->where('name', 'user');
            }
        )->get();

        return view('admin.index', [
            "my_container" => $container,
            "total_usuarios" => $total_usuarios,
            "leads_recebidos" => $leads_recebidos,
            "leads_hoje" => $leads_hoje,
            "leads" => $leads,
            "positivos" => $positivos,
            "negativos" => $negativos,
            "corretores" => $corretores,
        ]);
    }
}
