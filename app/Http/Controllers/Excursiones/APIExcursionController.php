<?php

namespace App\Http\Controllers\Excursiones;

use App\Http\Controllers\APIController;

use Illuminate\Http\Request;

use App\Models\Excursiones\Excursion;

use App\Models\Temporadas\Temporada;
use App\Models\ClasesServicios\ClaseServicio;

use App\Models\Monedas\Moneda;
use App\Models\Tipos\Tipo;

use App\Models\ExcursionesItinerarios\ExcursionItinerario;
use App\Models\Excursiones\TemporadasCostos\ExcursionTemporadaCosto;

use App\Http\Controllers\Excursiones\Fechas\APIExcursionFechaController;

use App\Http\Helpers\StringHelper;
use Illuminate\Support\Facades\DB;

class APIExcursionController extends APIController
{
    public static $setSqlMode;
    public static $tipos;
    public static $monedas;

    public static function index(Request $request, $apiKey = null, $idExcursion = null)
    {   
        $options = [
            "simplificada"      => filter_var($request->query("simplificada",       ($request["simplificada"]       ?? true     )), FILTER_VALIDATE_BOOLEAN),   
            "agregar"           => filter_var($request->query("agregar",            ($request["agregar"]            ?? ''       )), FILTER_SANITIZE_STRING),   
            "solo-activas"      => filter_var($request->query("solo-activas",       ($request["solo-activas"]       ?? true     )), FILTER_VALIDATE_BOOLEAN),
            "filtro-categorias" => filter_var($request->query("filtro-categorias",  ($request["filtro-categorias"]  ?? ''       )), FILTER_SANITIZE_STRING),
            "filtro-tipos"      => filter_var($request->query("filtro-tipos",       ($request["filtro-tipos"]       ?? ''       )), FILTER_SANITIZE_STRING),
            "excursion-id-no"   => filter_var($request->query("excursion-id-no",    ($request["excursion-id-no"]    ?? 0        )), FILTER_SANITIZE_NUMBER_INT),
            "limite"            => filter_var($request->query("limite",             ($request["limite"]             ?? 0        )), FILTER_SANITIZE_NUMBER_INT),
        ];
        
        if (self::$setSqlMode === null) {
            self::$setSqlMode = 'xp';

            DB::statement("SET SQL_MODE=''");
        }

        $excursiones = Excursion::leftJoin('tipos', 'tipos.id', '=', 'excursiones.id_tipo')
            ->leftJoin("monedas", "excursiones.id_moneda", "=", "monedas.id")
            ->leftJoin("excursiones_categorias", "excursiones.id", "=", "excursiones_categorias.id_excursion");
            
        $excursiones->where('excursiones.id_empresa', '=', $request->apiKey["business"]->id);

        if ($options["solo-activas"] === true) {
            $excursiones->where('excursiones.publicar_excursion', '=', "1");
        }
        
        if ($options["filtro-categorias"] !== '') {
            $whereInCategorias = explode(",", $options["filtro-categorias"]);
            $excursiones->whereIn('excursiones_categorias.id_categoria', $whereInCategorias);
        }
        
        if ($options["filtro-tipos"] !== '') {
            $whereInTipos = explode(",", $options["filtro-tipos"]);
            $excursiones->whereIn('excursiones.id_tipo', $whereInTipos);
        }

        if ($options["excursion-id-no"] !== 0) {
            $excursiones->where('excursiones.id', '!=', $options["excursion-id-no"]);
        }

        if ($idExcursion !== null) {
            $excursiones->where('excursiones.id', '=', $idExcursion);
        }

        $arrSelect = [
            'excursiones.id',
            'excursiones.id_empresa',
            'excursiones.id_usuario',
            'excursiones.nombre',
            'excursiones.descripcion',
            'excursiones.youtube',
            'excursiones.menores',
            'excursiones.infantes',
            'excursiones.hoteleria',
            'excursiones.vuelos',
            'excursiones.calendario',
            'excursiones.dias_disponible',
            'excursiones.cantidad_dias',
            'excursiones.itinerario_es',
            'excursiones.publicar_excursion',
            'excursiones.tipo_tarifa',
            'excursiones.cantidad_pasajeros_grupo',
            'excursiones.metodo_calculo_precio',
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
            'excursiones.id_moneda AS moneda',
            'excursiones.id_tipo as tipo',
        ];

        if ($options["simplificada"] === false) {
            $arrSelect[] = 'excursiones.created_at';
            $arrSelect[] = 'excursiones.updated_at';
            $arrSelect[] = 'excursiones.titulo_sitio';
            $arrSelect[] = 'excursiones.descripcion_sitio';
            $arrSelect[] = 'excursiones.keywords_sitio';
            $arrSelect[] = 'excursiones.itinerario_es';
            $arrSelect[] = 'excursiones.itinerario_en';
        }

        $excursiones
            ->groupBy('excursiones.id')
            ->orderBy("precio_desde", "asc")
            ->select($arrSelect);
        
        if ($options["limite"] > 0) {
            $excursiones
                ->limit($options["limite"]);
        }

        $excursiones = $excursiones->get();

        if ($options["agregar"] !== "") {
            $options["agregar"] = self::formatearTablasAgregadas($options["agregar"]);
        }
        
        if (($options["simplificada"] === false) || 
            (
                (   gettype($options["agregar"]) === "array"    ) &&
                (   isset($options["agregar"]["recomendaciones"]) )
            )
        ) {
            $excursiones->load('recomendaciones:id,nombre,descripcion,icono');
        }

        if (($options["simplificada"] === false) || 
            (
                (   gettype($options["agregar"]) === "array"    ) &&
                (   isset($options["agregar"]["sitios"]) )
            )
        ) {
            $excursiones->load('sitios:id,nombre,icono,id_icono_tipo,descripcion,latitud,longitud');
        }

        if (($options["simplificada"] === false) || 
            (
                (   gettype($options["agregar"]) === "array"    ) &&
                (   isset($options["agregar"]["categorias"]) )
            )
        ) {
            $excursiones->load(['categorias' => function ($query) {
                $query->leftJoin("categorias_imagenes AS temporal_tarjeta", function ($join) {
                    $join->on("categorias.id", "=", "temporal_tarjeta.id_categoria")->on("temporal_tarjeta.principal_tarjetas", "=", DB::raw(1));
                })
                ->leftJoin("categorias_imagenes AS temporal_portada", function ($join) {
                    $join->on("categorias.id", "=", "temporal_portada.id_categoria")->on("temporal_portada.principal_portadas", "=", DB::raw(1));
                })
                ->select(
                    [
                        "categorias.id",
                        "categorias.nombre",
                        "categorias.descripcion",

                        "temporal_tarjeta.id AS imagen_tarjeta_id",
                        "temporal_tarjeta.titulo AS imagen_tarjeta_titulo",
                        "temporal_tarjeta.descripcion AS imagen_tarjeta_descripcion",
                        "temporal_tarjeta.leyenda AS imagen_tarjeta_leyenda",
                        "temporal_tarjeta.texto_alternativo AS imagen_tarjeta_texto_alternativo",
                        "temporal_tarjeta.path AS imagen_tarjeta_path",

                        "temporal_portada.id AS imagen_portada_id",
                        "temporal_portada.titulo AS imagen_portada_titulo",
                        "temporal_portada.descripcion AS imagen_portada_descripcion",
                        "temporal_portada.leyenda AS imagen_portada_leyenda",
                        "temporal_portada.texto_alternativo AS imagen_portada_texto_alternativo",
                        "temporal_portada.path AS imagen_portada_path",
                    ]
                );
            }]);

            foreach ($excursiones as $excursion) {
                foreach ($excursion->categorias as $categoria) {
                    self::objetoImagenDesdeColumnas($categoria);
                }
            }
        
        }

        if (($options["simplificada"] === false) || 
            (
                (   gettype($options["agregar"]) === "array"    ) &&
                (   in_array("no-incluyes", $options["agregar"]) )
            )
        ) {
            $excursiones->load('noIncluyes:id,nombre,descripcion,icono,id_icono_tipo');
        }


        if (self::$tipos === null) {
            self::$tipos = Tipo::where('tipos.id_empresa', '=', $request->apiKey["business"]->id)
                    ->select(["id", "nombre", "descripcion", "icono"])
                    ->get();
        }

        if (self::$monedas === null) {
            self::$monedas = Moneda::where('monedas.id_empresa', '=', $request->apiKey["business"]->id)
                ->select(["id", "nombre", "iso", "tipo_cambio"])
                ->get();
        }
        
        $excursiones->load('incluyes:id,nombre,descripcion,icono,id_icono_tipo');
        $excursiones->load('imagenes:id,id_excursion,titulo,descripcion,leyenda,texto_alternativo,path,principal_tarjetas,principal_portadas');
                
        foreach ($excursiones as $excursion) {
            // Objeto Tipos
            $excursion->tipo = self::$tipos->firstWhere('id', $excursion->tipo);
            
            // Objeto moneda
            $excursion->moneda = self::$monedas->firstWhere('id', $excursion->moneda);
            
            // Objetos incluye
            $excursion->incluye = $excursion->incluyes;
            unset($excursion->incluyes);
            
            if ($options["simplificada"] === false) {
                // Objetos incluye
                $excursion->no_incluye = $excursion->noIncluyes;
                unset($excursion->noIncluyes);

                $excursion->sitios_turisticos   = $excursion->sitios;
                unset($excursion->sitios);
            }
        }

        if ((isset($request["json"]) && $request["json"] === false) || (isset($request["controller"]) && $request["controller"] === true)) {
            return $excursiones;
        }

        return response()->json([
            'code' => '200',
            'body' => [
                "excursiones" => $excursiones
            ]
        ], 200);
    }


    public static function show(Request $request, $apiKey, $idExcursion)
    {
        $options = [
            "columns" => filter_var($request->query("columns", ($request["columns"] ?? "")), FILTER_SANITIZE_STRING),   
        ];

        $request["controller"] = true;
        $request["simplificada"] = false;
        $excursion = self::index($request, $apiKey, $idExcursion)[0];

        $temporadas = Temporada::leftJoin('excursiones_temporadas_costos', 'temporadas.id', '=', 'excursiones_temporadas_costos.id_temporada')
            ->where('temporadas.id_empresa', '=', $request->apiKey["business"]->id)
            ->where('excursiones_temporadas_costos.id_excursion', '=', $idExcursion)
            ->groupBy('temporadas.id')
            ->select([
                'temporadas.id',
                'temporadas.nombre',
                DB::raw("
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
                    `excursiones_temporadas_costos`.`id_temporada` = `temporadas`.`id`
                    AND `excursiones_temporadas_costos`.`id_excursion` = $idExcursion
                ) AS precio_desde
                "),
            ])
            ->get();

        $clases = ClaseServicio::leftJoin('excursiones_temporadas_costos', 'clases_servicios.id', '=', 'excursiones_temporadas_costos.id_clase_servicio')
            ->where('clases_servicios.id_empresa', '=', $request->apiKey["business"]->id)
            ->where('excursiones_temporadas_costos.id_excursion', '=', $idExcursion)
            ->groupBy('clases_servicios.id')
            ->select(['clases_servicios.id', 'clases_servicios.nombre'])
            ->get();

        $costos = null;
        $costeos = null;
        $costosFirst = null;
        $infoDesde = null;

        if ($excursion->metodo_calculo_precio === 1) {
            $costos = ExcursionTemporadaCosto::where('excursiones_temporadas_costos.id_empresa', '=', $request->apiKey["business"]->id)
                ->where('excursiones_temporadas_costos.id_excursion', '=', $idExcursion)
                ->select(['excursiones_temporadas_costos.*'])
                ->orderBy(DB::raw("
                CASE
                    WHEN 
                        `excursiones_temporadas_costos`.`adulto_cuadruple` != 0 THEN `excursiones_temporadas_costos`.`adulto_cuadruple`
                    WHEN
                        `excursiones_temporadas_costos`.`adulto_triple` != 0 THEN `excursiones_temporadas_costos`.`adulto_triple`
                    WHEN
                        `excursiones_temporadas_costos`.`adulto_doble` != 0 THEN `excursiones_temporadas_costos`.`adulto_doble`
                    ELSE
                        `excursiones_temporadas_costos`.`adulto_sencilla`
                END"
                ))
                ->get();

            $costosFirst = $costos->first();

            $infoDesde = [
                "temporada" => $temporadas->firstWhere('id', $costosFirst->id_temporada)->toArray(),
                "clase" => $clases->firstWhere('id', $costosFirst->id_clase_servicio)->toArray(),
                "costos" => $costosFirst,
            ];
        } else if ($excursion->metodo_calculo_precio === 2) {
            $costeos = $excursion->costeos;

            foreach ($costeos as $costeo) {
                foreach ($costeo->campos as $campo) {
                    unset($campo->id_empresa);
                    unset($campo->id_usuario);
                    unset($campo->id_costeo);
                    unset($campo->created_at);
                    unset($campo->updated_at);
                }

                foreach ($costeo->pivot->campos as $campo) {
                    unset($campo->id);
                    unset($campo->id_empresa);
                    unset($campo->id_usuario);
                    unset($campo->id_excursion_costeo);
                    unset($campo->created_at);
                    unset($campo->updated_at);
                }

                foreach ($costeo->condiciones as $condicion) {
                    unset($condicion->id_empresa);
                    unset($condicion->id_usuario);
                    unset($condicion->id_costeo);
                    unset($condicion->created_at);
                    unset($condicion->updated_at);
                }

                unset($costeo->id_empresa);
                unset($costeo->id_usuario);
                unset($costeo->created_at);
                unset($costeo->updated_at);
            }

            $resultadoCosteos = [];

            // Se recorre cada costeo para obtener los valores de sus campos y calcular todas sus formulas
            foreach ($costeos as $costeo) {
                $arrVariablesCosteo = [];
                $costeo->pivot->campos; // Se obtienen los campos de la relación excursion-costeo

                $resultadoCosteos[] = [
                    "temporada" => $costeo->pivot->id_temporada,
                    "clase" => $costeo->pivot->id_clase_servicio,
                    "habitacion_tipo" => $costeo->pivot->id_habitacion_tipo,
                ];

                // Ahora se recorren los campos pero no de la relación, si no del costeo original
                foreach ($costeo->campos as $campo) {
                    $arrVariablesCosteo[$campo->identificador] = $campo->valor_defecto; // Se establecen valores por defecto

                    // Ahora se reemplazan los valores que son definidos por las excursiones
                    if ($campo->nombre === "CANTIDAD_PASAJEROS_GRUPO") {
                        $arrVariablesCosteo[$campo->identificador] = $excursion[$campo->identificador];
                    }

                    // Si fue asignado algún valor personalizado para el campo en la relación excursion-costeo se usa ese valor
                    if ($costeo->pivot->campos->contains("id_costeo_campo", $campo->id)) {
                        $arrVariablesCosteo[$campo->identificador] = $costeo->pivot->campos->firstWhere("id_costeo_campo", $campo->id)->valor;
                    }
                }

                // Se empieza a generar el string para hacer el calculo
                $identificadores = array_column($costeo->campos->toArray(), "identificador");
                $identificadoresCustom = [];

                foreach ($identificadores as $index => $identificador) {
                    $identificadoresCustom[] = '$arrVariablesCosteo["' . $identificador . '"]';
                    $identificadores[$index] = "/\b$identificador\b/";
                }

                $costeoFormulaPrecioCustom = preg_replace(
                    $identificadores,
                    $identificadoresCustom,
                    StringHelper::sanitizarInputFormulaCosteo(array_column($costeo->campos->toArray(), "nombre"), $costeo->formula_precio)
                );
                
                eval('$resultadoCosteos[count($resultadoCosteos) - 1]["costo"] = ' . $costeoFormulaPrecioCustom . ";");
                $resultadoCosteos[count($resultadoCosteos) - 1]["costeo"] = (object) [
                    "id" => $costeo->id,
                ];

                $infoDesde = $resultadoCosteos[count($resultadoCosteos) - 1];

                // Ahora se calculan las condiciones
                foreach ($costeo->condiciones as $condicion) {
                    $costeoFormulaPrecioCustom = preg_replace(
                        $identificadores,
                        $identificadoresCustom,
                        StringHelper::sanitizarInputFormulaCosteo(array_column($costeo->campos->toArray(), "nombre"), $condicion->formula_precio)
                    );

                    $resultadoCosteos[] = [
                        "temporada" => (object) ["id" => $costeo->pivot->id_temporada],
                        "clase" => (object) ["id" => $costeo->pivot->id_clase_servicio],
                        "habitacion" => (object) ["tipo" => $costeo->pivot->id_habitacion_tipo],
                    ];

                    eval('$resultadoCosteos[count($resultadoCosteos) - 1]["costo"] = ' . $costeoFormulaPrecioCustom . ";");
                    $resultadoCosteos[count($resultadoCosteos) - 1]["costeo"] = (object) [
                        "id" => $costeo->id,
                    ];
                    $resultadoCosteos[count($resultadoCosteos) - 1]["notas"] = "Con la condición: $condicion->condicion";

                    if ($resultadoCosteos[count($resultadoCosteos) - 1]["costo"] < $infoDesde["costo"]) {
                        $infoDesde = $resultadoCosteos[count($resultadoCosteos) - 1];
                    }
                }
            }

            if ($infoDesde !== null) {
                // Se actualiza en la BDD el precio_desde si es que cambió
                if ((float) $infoDesde["costo"] != (float) $excursion->precio_desde) {
                    $excursion->precio_desde = (string) $infoDesde["costo"];
    
                    Excursion::where('id', $excursion->id)
                        ->update(['precio_desde' => $infoDesde["costo"]]);
                }
            }
        }

        foreach ($temporadas as $temporada) {
            $temporadasClases = null;
            if ($excursion->metodo_calculo_precio === 1) {
                $temporadasClases = $clases->whereIn('id', array_column($costos->where('id_temporada', $temporada->id)->toArray(), "id_clase_servicio"))->values();
            } else if ($excursion->metodo_calculo_precio === 2) {
                $temporadaCosteos = $costeos->where('pivot.id_temporada', $temporada->id);
                $arrTemporadaClases = [];

                foreach ($temporadaCosteos as $temporadaCosteo) {
                    if (array_search($temporadaCosteo->pivot->id_clase_servicio, $arrTemporadaClases) === false) {
                        $arrTemporadaClases[] = $temporadaCosteo->pivot->id_clase_servicio;
                    }
                }

                $temporadasClases = $clases->whereIn('id', $arrTemporadaClases)->values();
            }

            $tmp = [];

            foreach ($temporadasClases as $clase) {
                $tmp[] = (object) $clase->toArray();
            }

            $temporada->clases = $tmp;
            
            foreach ($temporada->clases as $clase) {
                if ($excursion->metodo_calculo_precio === 1) {
                    $clase->costos = $costos->where('id_temporada', $temporada->id)->firstWhere('id_clase_servicio', $clase->id);

                    unset($clase->costos->id);
                    unset($clase->costos->id_empresa);
                    unset($clase->costos->id_usuario);
                    unset($clase->costos->id_excursion);
                    unset($clase->costos->id_temporada);
                    unset($clase->costos->id_clase_servicio);
                    unset($clase->costos->created_at);
                    unset($clase->costos->updated_at);
                } else if ($excursion->metodo_calculo_precio === 2) {
                    $claseCosteos = $costeos->where('pivot.id_temporada', $temporada->id)->where('pivot.id_clase_servicio', $clase->id);

                    $arrCosteos = [];

                    foreach ($claseCosteos as $claseCosteo) {
                        $arrCosteos[] = (object) [
                            "id" => $claseCosteo->id,
                            "nombre" => $claseCosteo->nombre,
                        ];
                    }

                    $clase->costeos = $arrCosteos;
                }
            }
        }        

        if ($excursion->calendario === 1) {
            $fechas = APIExcursionFechaController::index($request, null, $idExcursion);
            $excursion->fechas = $fechas;
        }

        $itinerarios = ExcursionItinerario::where('id_empresa', '=', $request->apiKey["business"]->id)
            ->where('id_excursion', '=', $idExcursion)
            ->select("id", "contenido", "dia", "icono")
            ->get();

        // Actualizar como se calcula el info_desde para los costeos
        $excursion->info_desde = $infoDesde;
        $excursion->temporadas = $temporadas;
        $excursion->clases = $clases;
        $excursion->itinerarios = $itinerarios;

        if (isset($options["columns"]) && ($options["columns"] != "")) {
            $columns = explode(",", $options["columns"]);

            $newExcursion = [];
            foreach ($columns as $column) {
                $newExcursion[$column] = $excursion[$column];
            }

            $excursion = $newExcursion;
        }

        $request["controller"] = true;
        $request["simplificada"] = true;
        $request["limit"] = 5;

        $request["filtro-categorias"] = implode(",", array_column($excursion->categorias->toArray(), "id"));
        $request["excursion-id-no"] = $excursion->id;

        $excursion->excursiones_relacionadas = self::index($request, $apiKey);
        
        if (isset($request["json"]) && $request["json"] === false) {
            return $excursion;
        }

        return response()->json([
            'code' => '200',
            'body' => [
                "excursion" => $excursion
            ]
        ], 200);
    }
}
