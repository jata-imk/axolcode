<?php

namespace App\Http\Controllers\Costeos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Costeos\Costeo;

class APICosteoController extends Controller
{
    public static function index(Request $request, $apiKey = null, $idCosteo = null)
    {
        $options = [
            "id-excursion" => filter_var($request->query("id-excursion", ($request["id-excursion"] ?? "")), FILTER_SANITIZE_STRING),   
        ];

        $costeos = Costeo::where("costeos.id_empresa", "=", $request->apiKey["business"]->id);

        if ($options["id-excursion"] !== "") { 
            $costeos = $costeos->leftJoin("excursiones_costeos", "costeos.id", "=", "excursiones_costeos.id_costeo")
                ->where("excursiones_costeos.id_excursion", "=", $options["id-excursion"]);
        }

        if ($idCosteo !== null) { 
            $costeos = $costeos->where("id", "=", $idCosteo);
        }

        $costeos = $costeos
            ->select()
            ->get();

            foreach ($costeos as $costeo) {
                $costeo->campos = $costeo->campos;
                $costeo->condiciones = $costeo->condiciones;
            }

        if ((isset($request["json"]) && $request["json"] === false) || (isset($request["controller"]) && $request["controller"] === true)) {
            return $costeos;
        }

        return response()->json([
            'code' => '200',
            'body' => [
                "costeos" => $costeos,
            ]
        ]);
    }

    public static function show(Request $request, $apiKey = null, $idCosteo)
    {
        $request["controller"] = true;

        $costeo = self::index($request, $apiKey, $idCosteo)[0];

        if ((isset($request["json"]) && $request["json"] === false)) {
            return $costeo;
        }

        return response()->json([
            'code' => '200',
            'body' => [
                "costeo" => $costeo,
            ]
        ]);
    }
}
