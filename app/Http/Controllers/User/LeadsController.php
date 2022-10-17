<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LeadsController extends Controller
{

    public function atualizarStatus(Request $request)
    {

        $lead = Lead::find($request->lead_id);
        $lead->status_negociacao = $request->status;
        $lead->save();

        return response()->json([
            "success" => true,
            "msg" => 'Status atualizado!',
        ], Response::HTTP_OK);
    }

    public function avaliar(Request $request)
    {

        $lead = Lead::find($request->lead_id);
        $lead->avaliacao = $request->avaliacao;
        $lead->data_avaliacao  = Carbon::now();
        $lead->comentario_avaliacao = $request->comentario;
        $lead->save();

        return response()->json([
            "success" => true,
            "msg" => 'Lead avaliado!',
        ], Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        Lead::create([
            'nome' => $request->nome,
            'possui_cnpj' => $request->possui_cnpj,
            'telefone' => $request->telefone,
            'status' => "VALIDADO",
            'ocupacao' => $request->ocupacao,
            'bairro' => $request->bairro,
            'possui_plano' => $request->possui_plano,
            'qtd_vidas' => $request->qtd_vidas,
            'complemento' => $request->complemento,
            'user_id' => Auth::user()->id,
            'origem_lead' => "CADASTRO MANUAL"
        ]);

        return response()->json([
            "success" => true,
            "msg" => 'Lead cadastrado!',
        ], Response::HTTP_OK);
    }
}
