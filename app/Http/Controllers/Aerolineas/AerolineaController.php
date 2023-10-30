<?php

namespace App\Http\Controllers\Aerolineas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Aerolineas\Aerolinea;

class AerolineaController extends Controller
{
    public function index(Request $request)
    {
        $aerolineas = null;

        if ($request->query("q")) {
            $aerolineas = Aerolinea::where(DB::raw('CONCAT_WS(" ", name, alias, callsign)'), "like", "%" . $request->query("q") . "%")
                            ->select()
                            ->get();
        } else {
            $aerolineas = Aerolinea::select()->get();
        }

        return response()->json([
            'code' => '200',
            'body' => [
                "aerolineas" => $aerolineas
            ]
        ], 200);
    }
}
