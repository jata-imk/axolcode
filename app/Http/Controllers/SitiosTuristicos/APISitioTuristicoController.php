<?php

namespace App\Http\Controllers\SitiosTuristicos;

use App\Http\Controllers\APIController;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

use App\Models\SitiosTuristicos\SitioTuristico;

class APISitioTuristicoController extends APIController
{
    public static $columnasSitiosCompletas = [
        "id",
        "nombre",
        "descripcion",
        "icono",
        "id_icono_tipo",
        "latitud",
        "longitud",
        "linea1",
        "linea2",
        "linea3",
        "codigo_postal",
        "ciudad",
        "estado",
        "codigo_pais",
    ];

    
    public static $columnasSitiosSimplificadas = [
        "id",
        "nombre",
        "descripcion",
        "icono",
        "id_icono_tipo",
        "latitud",
        "longitud",
    ];


    public function __construct() {
        self::$columnasSitiosCompletas[] = DB::raw('CONCAT_WS(", ", nombre, estado, codigo_pais) AS nombre_completo');
        self::$columnasSitiosSimplificadas[] = DB::raw('CONCAT_WS(", ", nombre, estado, codigo_pais) AS nombre_completo');
    }


    public static function index(Request $request, $apiKey = null, $idSitio = null)
    {
        $options = [
            "simplificada"      => filter_var($request->query("simplificada",       ($request["simplificada"]       ?? false    )), FILTER_VALIDATE_BOOLEAN),   
            "agregar"           => filter_var($request->query("agregar",            ($request["agregar"]            ?? ""       )), FILTER_SANITIZE_STRING),   
        ];

        if ($options["agregar"] !== "") {
            $options["agregar"] = self::formatearTablasAgregadas($options["agregar"]);
        }

        $sitios = SitioTuristico::where('id_empresa', '=', $request->apiKey["business"]->id)->withCount('excursiones');
        
        if (($request->query("q")) && ($request->query("q") != "")) {
            $sitios = $sitios->where(DB::raw('CONCAT_WS(" ", nombre, ciudad, estado)'), "like", "%" . $request->query("q") . "%");
        }
        
        if ((gettype($options["agregar"]) === "array") && (isset($options["agregar"]["imagenes"]))) {
            $sitios = $sitios->with("imagenes:id,id_sitio_turistico,titulo,descripcion,leyenda,texto_alternativo,path,principal_tarjetas,principal_portadas");
        }

        if ($idSitio !== null) {
            $sitios = $sitios->where('id', '=', $idSitio);
        }
            
        $sitios = $sitios
            ->select(
                ($options["simplificada"] === true)
                ?
                self::$columnasSitiosSimplificadas
                :
                self::$columnasSitiosCompletas
            )
            ->get();

        if ((isset($request["json"]) && $request["json"] === false) || (isset($request["controller"]) && $request["controller"] === true)) {
            return $sitios;
        }

        return response()->json([
            'code' => '200',
            'body' => [
                "sitios" => $sitios
            ]
        ], 200);
    }


    public static function show(Request $request, $apiKey, $idSitio)
    {
        $request["controller"] = true;
        $request["simplificada"] = false;
        $sitioTuristico = self::index($request, $apiKey, $idSitio)[0];

        if (isset($request["json"]) && $request["json"] === false) {
            return $sitioTuristico;
        }
        
        $sitioTuristico->load("imagenes:id,id_sitio_turistico,titulo,descripcion,leyenda,texto_alternativo,path,principal_tarjetas,principal_portadas");
        $sitioTuristico->excursiones = $sitioTuristico
            ->excursiones()
            ->with('incluyes:id,nombre,descripcion,icono,id_icono_tipo')
            ->select(
                "excursiones.*",
                DB::raw("
                    (
                        SELECT path
                        FROM excursiones_imagenes
                        
                        WHERE id_excursion = excursiones.id AND principal_tarjetas = 1 
                    ) AS path
                "),
                DB::raw("
                CASE WHEN `excursiones`.`metodo_calculo_precio` = 1 THEN
                    (SELECT
                        CASE WHEN MIN(`excursiones_temporadas_costos`.`adulto_cuadruple`) = 0 THEN 
                            ( SELECT  CASE WHEN MIN(`excursiones_temporadas_costos`.`adulto_triple`) = 0 THEN
                                    ( SELECT CASE WHEN MIN(`excursiones_temporadas_costos`.`adulto_doble`) = 0 THEN
                                            MIN(`excursiones_temporadas_costos`.`adulto_sencilla`) 
                                        ELSE MIN(`excursiones_temporadas_costos`.`adulto_doble`) 
                                        END
                                    )
                                ELSE MIN(`excursiones_temporadas_costos`.`adulto_triple`)
                                END
                            )
                        ELSE MIN(`excursiones_temporadas_costos`.`adulto_cuadruple`)
                        END
                    FROM
                        `excursiones_temporadas_costos`
                    WHERE
                        `excursiones_temporadas_costos`.`id_excursion` = `excursiones`.`id`
                    )
                WHEN `excursiones`.`metodo_calculo_precio` = 2 THEN
                    `excursiones`.`precio_desde`
                ELSE
                    0.00
                END AS precio_desde
                "),
            )
            ->get();
        
        foreach ($sitioTuristico->excursiones as $excursion) {
            $excursion->imagenes = [
                (object) [
                    "id_excursion" => $excursion->id,
                    "path" => $excursion->path,
                    "principal_tarjetas" => 1,
                    "principal_portadas" => 0,
                ]
            ];
            
            $excursion->incluye = $excursion->incluyes; // Por motivos de compatibilidad

            unset($excursion->path);
            unset($excursion->incluyes); // Por motivos de compatibilidad
            unset($excursion->id_empresa);
            unset($excursion->id_usuario);
            unset($excursion->created_at);
            unset($excursion->updated_at);
        }

        return response()->json([
            'code' => '200',
            'body' => [
                "sitio" => $sitioTuristico
            ]
        ], 200);
    }
}
