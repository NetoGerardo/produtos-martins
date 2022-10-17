<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LeadsController extends Controller
{

    public function encaminhar(Request $request)
    {

        $lead = Lead::find($request->lead_id);
        $lead->origem_lead = 'ENCAMINHADO';
        $lead->user_id = $request->corretor_id;
        $lead->save();

        return response()->json([
            "success" => true,
            "msg" => 'Lead encaminhado!',
        ], Response::HTTP_OK);
    }
}
