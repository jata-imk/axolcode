<?php

namespace App\Http\Controllers\Excursiones\Fechas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Excursiones\Fechas\ExcursionFecha;
use App\Models\Temporadas\Temporada;


class APIExcursionFechaController extends Controller
{
    public static function index(Request $request, $apiKey = null, $idExcursion = null)
    {
        $options = [
            "between" => filter_var($request->query("between", ($request["between"] ?? "")), FILTER_SANITIZE_STRING),   
            "temporadas" => filter_var($request->query("temporadas", ($request["temporadas"] ?? "")), FILTER_SANITIZE_STRING),
            "clases_servicios" => filter_var($request->query("clases_servicios", ($request["clases_servicios"] ?? "")), FILTER_SANITIZE_STRING),
            "fecha-inicio" => filter_var($request->query("fecha-inicio", ($request["fecha-inicio"] ?? "")), FILTER_SANITIZE_STRING),
            "fecha-fin" => filter_var($request->query("fecha-fin", ($request["fecha-fin"] ?? "")), FILTER_SANITIZE_STRING)
        ];

        $fechas = ExcursionFecha::leftJoin("excursiones_temporadas_costos", "excursiones_fechas.id_temporada_costo", "=", "excursiones_temporadas_costos.id")
            ->leftJoin("clases_servicios", "excursiones_temporadas_costos.id_clase_servicio", "=", "clases_servicios.id")
            ->where("excursiones_temporadas_costos.id_excursion", "=", $idExcursion)
            ->where("excursiones_fechas.fecha_inicio", ">=", date("Y-m-d"));

        if (($options["fecha-inicio"] != "") && ($options["fecha-fin"] != "")) {
            $fechas = $fechas
                ->where("excursiones_fechas.fecha_inicio", "=", $options["fecha-inicio"])
                ->where("excursiones_fechas.fecha_fin", "=", $options["fecha-fin"]);
        }

        if ($options["between"] != "") {
            [$fechaInicio, $fechaFin] = explode(',', $request->query("between"));
            $fechas = $fechas->where("excursiones_fechas.fecha_inicio", ">=", $fechaInicio)->where("excursiones_fechas.fecha_fin", "<=", $fechaFin);
        }

        if ($options["temporadas"] != "") {
            $temporadas = $request->query("temporadas");
            $fechas = $fechas->whereIn("excursiones_temporadas_costos.id_temporada", explode(",", $temporadas));
        }

        if ($options["clases_servicios"] != "") {
            $clasesServicios = $request->query("clases_servicios");
            $fechas = $fechas->whereIn("excursiones_temporadas_costos.id_clase_servicio", explode(",", $clasesServicios));
        }

        // TODO: Seleccionar el precio mas bajo de cada temporada
        DB::statement("SET SQL_MODE=''");

        $fechas = $fechas->orderBy('excursiones_fechas.fecha_inicio', 'asc')
            ->groupBy('excursiones_fechas.fecha_inicio', 'excursiones_fechas.fecha_fin')
            ->select([
                'excursiones_fechas.id',
                'excursiones_fechas.fecha_inicio',
                'excursiones_fechas.fecha_fin',
                DB::raw("GROUP_CONCAT(DISTINCT `excursiones_temporadas_costos`.`id_temporada` SEPARATOR '\\r\\n') AS id_temporada"),
                DB::raw("GROUP_CONCAT( `excursiones_temporadas_costos`.`id_clase_servicio` SEPARATOR '\\r\\n') AS id_clase_servicio"),
                DB::raw("GROUP_CONCAT( `clases_servicios`.`nombre` SEPARATOR '\\r\\n') AS nombre_clase_servicio"),
                DB::raw("GROUP_CONCAT( `excursiones_fechas`.`cupo` SEPARATOR '\\r\\n') AS cupo"),
                DB::raw("GROUP_CONCAT( `excursiones_fechas`.`publicar_fecha` SEPARATOR '\\r\\n') AS publicar_fecha"),
            ])
            ->get();

        $temporadas = Temporada::leftJoin('excursiones_temporadas_costos', 'temporadas.id', '=', 'excursiones_temporadas_costos.id_temporada')
            ->where('temporadas.id_empresa', '=', $request->apiKey["business"]->id)
            ->where('excursiones_temporadas_costos.id_excursion', '=', $idExcursion)
            ->groupBy('temporadas.id')
            ->select([
                'temporadas.id',
                'temporadas.nombre',
                'temporadas.color',
                'temporadas.background_color',
            ])
            ->get();

        for ($i = 0, $l = $fechas->count(); $i < $l; $i++) {    
            $fechaNuevoObjeto = [];

            $fechasIdClases     = explode("\r\n", $fechas[$i]->id_clase_servicio);
            $fechasNombreClases = explode("\r\n", $fechas[$i]->nombre_clase_servicio);
            $fechasCupos        = explode("\r\n", $fechas[$i]->cupo);
            $fechasPublicar     = explode("\r\n", $fechas[$i]->publicar_fecha);

            for ($j = 0, $m = count($fechasIdClases); $j < $m; $j++) {                
                $fechaNuevoObjeto[] = (object) [
                    "id" => $fechasIdClases[$j],
                    "nombre" => $fechasNombreClases[$j],
                    "cupo" => $fechasCupos[$j],
                    "publicar_fecha" => $fechasPublicar[$j],
                ];
            }

            $fechas[$i]->temporada = $temporadas->firstWhere("id", "=", $fechas[$i]->id_temporada);
            $fechas[$i]->clases = $fechaNuevoObjeto;
            
            unset($fechas[$i]->id_clase_servicio);
            unset($fechas[$i]->nombre_clase_servicio);
            unset($fechas[$i]->cupo);
            unset($fechas[$i]->publicar_fecha);
            unset($fechas[$i]->id_temporada);
        }

        if ((isset($request["json"]) && $request["json"] === false) || (isset($request["controller"]) && $request["controller"] === true)) {
            return $fechas;
        }

        return response()->json([
            'code' => '200',
            'body' => [
                "fechas" => $fechas,
            ]
        ]);
    }
}
