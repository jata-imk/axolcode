<?php

namespace App\Http\Controllers\Excursiones;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

use App\Models\Empresas\Empresa;
use App\Models\Excursiones\Excursion;

use App\Models\Tipos\Tipo;
use App\Models\Costeos\Costeo;
use App\Models\Servicios\Servicio;
use App\Models\Categorias\Categoria;
use App\Models\Recomendaciones\Recomendacion;
use App\Models\Promociones\Promocion;
use App\Models\Monedas\Moneda;
use App\Models\Temporadas\Temporada;
use App\Models\ClasesServicios\ClaseServicio;

use App\Models\ExcursionesIncluye\ExcursionIncluye;
use App\Models\ExcursionesNoIncluye\ExcursionNoIncluye;
use App\Models\ExcursionesCategorias\ExcursionCategoria;
use App\Models\ExcursionesRecomendaciones\ExcursionRecomendacion;
use App\Models\ExcursionesSitiosTuristicos\ExcursionSitioTuristico;
use App\Models\ExcursionesItinerarios\ExcursionItinerario;
use App\Models\Excursiones\Imagenes\ExcursionesImagenes;
use App\Models\Excursiones\Costeos\ExcursionCosteo;
use App\Models\Excursiones\Costeos\Campos\ExcursionCosteoCampo;
use App\Models\Excursiones\TemporadasCostos\ExcursionTemporadaCosto;

use App\Models\ExcursionesPromociones\ExcursionPromocion;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Excursiones\APIExcursionController;

class ExcursionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index(Request $request)
    {
        $this->authorize("viewAny", Excursion::class);

        $miEmpresa = Empresa::find(Auth::user()->id_empresa);

        $request->merge([
            "apiKey" => ["business" => (object) ["id" => Auth::user()->id_empresa]],
            "json" => false,
            "simplificada" => true,
            "solo-activas" => false,
        ]);

        $excursiones = APIExcursionController::index($request);

        return view('excursiones.index', compact(
            'excursiones',
            'miEmpresa'
        ));
    }


    public function show(Request $request, $idExcursion)
    {
        $newApi = filter_var($request->query("newApi", ($request["newApi"] ?? false)), FILTER_VALIDATE_BOOLEAN);
        if ($newApi === true) {
            $request->merge([
                "apiKey" => ["business" => (object) ["id" => Auth::user()->id_empresa]],
                "json" => false,
            ]);
    
            return APIExcursionController::show($request, null, $idExcursion);
        }

        return $this->obtenerExcursion($idExcursion);
    }


    public function create()
    {
        $this->authorize("create", Excursion::class);

        $idEmpresa = Auth::user()->id_empresa;

        $promociones = Promocion::where('id_empresa', '=', $idEmpresa )
            ->select()
            ->get();

        $servicios = Servicio::where('id_empresa', '=', $idEmpresa )
            ->select()
            ->get();

        $tipos = Tipo::where('id_empresa', '=', $idEmpresa )
            ->select()
            ->get();

        $categorias = Categoria::where('id_empresa', '=', $idEmpresa )
            ->select()
            ->get();

        $recomendaciones = Recomendacion::where('id_empresa', '=', $idEmpresa )
            ->select()
            ->get();

        $monedas = Moneda::where('id_empresa', '=', $idEmpresa)
            ->select()
            ->get();

        return view('excursiones.agregar', compact(
            'promociones',
            'servicios',
            'tipos',
            'categorias',
            'recomendaciones',
            'monedas'
        ));
    }


    public function store(Request $request)
    {
        
        $this->authorize("create", Excursion::class);
        
        $idEmpresa = Auth::user()->id_empresa;
        $idUsuario = Auth::user()->id;
        
        $request["id_empresa"] = $idEmpresa;
        $request["id_usuario"] = $idUsuario;
        
        // Campos opcionales
        $request["youtube"] = $request["youtube"] ?? "";

        // Formateo de los días disponibles
        if ((int) $request->input("calendario") === 0) {
            $request["dias_disponible"] = join(",", $request->input("dias_disponible") ?? []);
        } else {
            $request["dias_disponible"]  = "";
        }
        
        $excursion = Excursion::create($request->all());

        $mensaje = '';
        if ($request->hasFile("itinerario")) {
            $extension = $request->file("itinerario")->extension();
            $nombreBase = Str::random(10) . "-" . time();
            $nombreItinerario = $nombreBase . ".$extension";

            $path = $request->file("itinerario")->storeAs(
                "empresas/$idEmpresa/excursiones/$excursion->id/itinerarios",
                $nombreItinerario,
                'public'
            );

            $excursion->itinerario_es = $path;
            $excursion->save();

            $mensaje = "Excursion agregado correctamente. Itinerario guardado. ";
        } else {
            $mensaje = "Excursion agregado correctamente. El itinerario no se guardó por que no es un PDF. ";
        }

        if ($request["id_promocion"] > 0) {
            $formPromo["id_empresa"]      = $idEmpresa;
            $formPromo["id_usuario"]      = $idUsuario;

            $formPromo["id_excursion"]    = $excursion->id;
            $formPromo["id_promocion"]    = $request["id_promocion"];
            $formPromo["paxes_promocion"] = $request["paxes_promocion"];
            $formPromo["limitado"]        = $request["limitado"];

            if ($request["limitado"] > 0) {
                $formPromo["limite"] = $request["limite"];
            } else {
                $formPromo["limite"] = 0;
            }

            if ($request["vigencia"] !== null) {
                $formPromo["vigencia"] = date("Y-m-d", strtotime($request["vigencia"]));
            } else {
                $formPromo["vigencia"] = null;
            }

            if ($request["booking_window"] !== null) {
                $booking_window = explode("-", $request["booking_window"]);
                $formPromo["booking_window_inicio"] = date("Y-m-d", strtotime($booking_window[0]));
                $formPromo["booking_window_fin"] = date("Y-m-d", strtotime($booking_window[1]));
            } else {
                $formPromo["booking_window_inicio"] = null;
                $formPromo["booking_window_fin"] = null;
            }

            if ($request["travel_window"] !== null) {
                $travel_window = explode("-", $request["travel_window"]);
                $formPromo["travel_window_inicio"] = date("Y-m-d", strtotime($travel_window[0]));
                $formPromo["travel_window_fin"] = date("Y-m-d", strtotime($travel_window[1]));
            } else {
                $formPromo["travel_window_inicio"] = null;
                $formPromo["travel_window_fin"] = null;
            }

            ExcursionPromocion::create($formPromo);
        }

        if ($request->incluye) {
            $this->addIncluyes($request->incluye, $excursion->id);
        }

        if ($request->no_incluye) {
            $this->addNoIncluye($request->no_incluye, $excursion->id);
        }

        if ($request->categoria) {
            $this->addCategorias($request->categoria, $excursion->id);
        }

        if ($request->recomendacion) {
            $this->addRecomendaciones($request->recomendacion, $excursion->id);
        }

        if ($request->sitios) {
            $this->sincronizarSitios($request->sitios, $excursion->id);
        }

        session()->flash('message', $mensaje);

        return response()->json([
            'code' => '201',
            'body' => [
                "redirect_url" => route('excursiones.index'),
                "id_excursion" => $excursion->id,
                "session_flash" => $mensaje
            ]
        ], 201);
    }


    public function edit($idExcursion)
    {
        $excursion = Excursion::find($idExcursion);
        
        $idExcursion = $excursion->id;
        $idEmpresa = Auth::user()->id_empresa;

        $this->authorize("view", $excursion);

        //////////////////////////////////////////////////////////
        // Primero obtenemos todos los datos en general de las  //
        // tablas principales relacionadas a las excursiones    //
        //////////////////////////////////////////////////////////
        // Obtenemos los tipos de excursiones existentes
        $tipos = Tipo::where('id_empresa', '=', $idEmpresa)
            ->select()
            ->get();        

        // Ahora pasamos a obtener la información de los servicios, recomendaciones y categorías
        $servicios = Servicio::where('id_empresa', '=', $idEmpresa)
            ->select()
            ->get();

        $recomendaciones = Recomendacion::where('id_empresa', '=', $idEmpresa)
            ->select()
            ->get();

        $categorias = Categoria::where('id_empresa', '=', $idEmpresa)
            ->select()
            ->get();

        // Ahora a los costos de las temporadas
        $monedas = Moneda::where('id_empresa', '=', $idEmpresa)
            ->select()
            ->get();

        $temporadas = Temporada::where('id_empresa', '=', $idEmpresa)
            ->select()
            ->get();

        $clasesServicios = ClaseServicio::where('id_empresa', '=', Auth::user()->id_empresa)
            ->select()
            ->get();

        $excursionTemporadasCostos = ExcursionTemporadaCosto::leftJoin('clases_servicios', 'excursiones_temporadas_costos.id_clase_servicio', '=', 'clases_servicios.id')
            ->where('id_excursion', '=', $idExcursion)
            ->select(['excursiones_temporadas_costos.*', 'clases_servicios.nombre as nombre_clase_servicio'])
            ->get();

        $costeos =  Costeo::where('id_empresa', '=', $idEmpresa)
            ->select()
            ->get();

        return view('excursiones.editar', compact(
            'excursion',
            'tipos',
            'servicios',
            'categorias',
            'recomendaciones',
            'monedas',
            'temporadas',
            'clasesServicios',
            'excursionTemporadasCostos',
            'costeos',
        ));
    }

    
    public function update(Request $request, $idExcursion)
    {
        $excursion = Excursion::find($idExcursion);

        // Verificamos si el usuario que está editando posee permisos para hacer esta acción
        $this->authorize("update", $excursion);

        $idEmpresa = Auth::user()->id_empresa;

        // Formateo de los días disponibles
        if ((int) $request->input("calendario") === 0) {
            $request["dias_disponible"] = join(",", $request->input("dias_disponible") ?? []);
        } else {
            $request["dias_disponible"]  = "";
        }
        
        $excursion->fill( array_merge( $excursion->toArray(), $request->all() ) );

        if ($excursion->isDirty()) {
            $excursion->save();
        }

        // Información de temporadas
        $this->sincronizarTemporadas($request, $excursion);
        $this->sincronizarCosteos($request, $excursion);

        // Actualizamos algunas relaciones
        $valoresPivote = [
            "id_empresa" => Auth::user()->id_empresa,
            "id_usuario" => Auth::user()->id,
        ];

        //Actualizamos incluyes, no incluyes, categorías, recomendaciones y también sitios turisticos
        $excursion->incluyes()->syncWithPivotValues($request->incluye, $valoresPivote);
        $excursion->noIncluyes()->syncWithPivotValues($request->no_incluye, $valoresPivote);
        $excursion->categorias()->syncWithPivotValues($request->categoria, $valoresPivote);
        $excursion->recomendaciones()->syncWithPivotValues($request->recomendacion, $valoresPivote);
        $excursion->sitios()->syncWithPivotValues($request->sitios, $valoresPivote);

        //Actualizamos itinerarios
        $this->sincronizarItinerarios($request, $excursion);

        //Sustituimos itinerario
        if ($request->has("itinerario")) {
            //Borramos el antiguo itinerario
            if ($excursion->itinerario_es !== null) {
                Storage::disk("public")->delete($excursion->itinerario_es);
            }

            $extension = $request->file("itinerario")->extension();
            $nombreBase = Str::random(10) . "-" . time();
            $nombreItinerario = $nombreBase . ".$extension";

            $path = $request->file("itinerario")->storeAs(
                "empresas/$idEmpresa/excursiones/$excursion->id/itinerarios",
                $nombreItinerario,
                'public'
            );

            $excursion->itinerario_es = $path;
            $excursion->save();

            $mensaje = "Excursion editada correctamente. Se actualizó el itinerario";
        } else {
            $mensaje = "Excursion editada correctamente";
        }

        return redirect()->route('excursiones.index')->with('message', $mensaje);
    }


    public function destroy(Request $request, Excursion $excursion)
    {
        $this->authorize("delete", $excursion);

        if ($excursion->publicar_excursion === 1) {
            return response()->json([
                'code' => '400',
                'body' => [
                    "msg" => "La excursion esta activa en la pagina web, por favor primero desactive esta opción.",
                ]
            ], 400);
        }

        // Eliminamos las relaciones con la tabla 'Excursiones Incluye'
        DB::table('excursiones_incluye')
                ->where('id_excursion', '=', $excursion->id)
                ->delete();

        // Eliminamos las relaciones con la tabla 'Excursiones No Incluye'
        DB::table('excursiones_no_incluye')
                ->where('id_excursion', '=', $excursion->id)
                ->delete();

        // Eliminamos las relaciones con la tabla 'Excursiones Categorias'
        DB::table('excursiones_categorias')
                ->where('id_excursion', '=', $excursion->id)
                ->delete();

        // Eliminamos las relaciones con la tabla 'Excursiones Recomendaciones'
        DB::table('excursiones_recomendaciones')
                ->where('id_excursion', '=', $excursion->id)
                ->delete();

        // Eliminamos las relaciones con la tabla 'Excursiones Itinerarios'
        DB::table('excursiones_itinerarios')
                ->where('id_excursion', '=', $excursion->id)
                ->delete();

        // Eliminamos las relaciones con la tabla 'Excursiones Imágenes'
        DB::table('excursiones_imagenes')
                ->where('id_excursion', '=', $excursion->id)
                ->delete();

        // Eliminamos las relaciones con la tabla 'Excursiones Temporadas Costos'
        DB::table('excursiones_temporadas_costos')
                ->where('id_excursion', '=', $excursion->id)
                ->delete();

        // Eliminamos las relaciones con la tabla 'Excursiones Promociones'
        DB::table('excursiones_promociones')
            ->where('id_excursion', '=', $excursion->id)
            ->delete();

        // TODO: Analizar todas las relaciones de las excursiones y determinar si se pueden borrar (Solo si no se han hecho reservaciones)

        $excursion->delete();

        return response()->json([
            'code' => '200',
            'body' => [
                "msg" => "La excursion y todas sus relaciones han sido eliminadas exitosamente.",
            ]
        ], 200);
    }


    private function addIncluyes($incluyes, $excursion)
    {
        foreach ($incluyes as $incluye) {
            if ($incluye != null) {
                ExcursionIncluye::create([
                    'id_empresa'    => Auth::user()->id_empresa,
                    'id_usuario'    => Auth::user()->id,
                    'id_excursion'  => $excursion,
                    'id_incluye'    => $incluye
                ]);
            }
        }
    }


    private function addNoIncluye($noincluyes, $excursion)
    {
        foreach ($noincluyes as $no_incluye) {
            if ($no_incluye != null) {
                ExcursionNoIncluye::create([
                    'id_empresa'    => Auth::user()->id_empresa,
                    'id_usuario'    => Auth::user()->id,
                    'id_excursion'  => $excursion,
                    'id_no_incluye' => $no_incluye
                ]);
            }
        }
    }


    private function addRecomendaciones($recomendaciones, $excursion)
    {
        foreach ($recomendaciones as $recomendacion) {
            if ($recomendacion != null) {
                ExcursionRecomendacion::create([
                    'id_empresa'        => Auth::user()->id_empresa,
                    'id_excursion'      => $excursion,
                    'id_usuario'        => Auth::user()->id,
                    'id_recomendacion'  => $recomendacion
                ]);
            }
        }
    }


    private function sincronizarSitios($sitios, $excursion)
    {
        $excursionSitios = ExcursionSitioTuristico::where("id_excursion", "=", $excursion)
            ->select()
            ->get();

        $sitiosOriginales = array_column($excursionSitios->toArray(), "id_sitio_turistico");
        $sitiosActualizados = $sitios ?? [];

        $sitiosActualizar = [];
        $sitiosAgregar = [];
        $sitiosEliminar = [];

        foreach ($sitiosActualizados as $idSitioActualizado) {
            if (array_search($idSitioActualizado, $sitiosOriginales) !== false) {
                $sitiosActualizar[] = (int) $idSitioActualizado;
            } else {
                $sitiosAgregar[] = (int) $idSitioActualizado;
            }
        }

        foreach ($sitiosOriginales as $sitioOriginalId) {
            if (!(array_search($sitioOriginalId, $sitiosActualizados) !== false)) {
                $sitiosEliminar[] = (int) $sitioOriginalId;
            }
        }

        if (count($sitiosEliminar) > 0) {
            DB::table('excursiones_sitios_turisticos')
                ->where('id_excursion', '=', $excursion)
                ->whereIn('id_sitio_turistico', $sitiosEliminar)
                ->delete();
        }

        if (count($sitiosAgregar) > 0) {
            $arrSitiosAgregar = [];

            foreach ($sitiosAgregar as $idSitioAgregar) {
                $arrSitiosAgregar[] = [
                    "id_empresa" => Auth::user()->id_empresa,
                    "id_usuario" => Auth::user()->id,
                    "id_excursion" => $excursion,
                    "id_sitio_turistico" => $idSitioAgregar,
                ];
            }

            ExcursionSitioTuristico::insert($arrSitiosAgregar);
        }
    }


    private function addCategorias($categorias, $excursion)
    {
        foreach ($categorias as $categoria) {
            if ($categoria != null) {
                ExcursionCategoria::create([
                    'id_empresa'    => Auth::user()->id_empresa,
                    'id_excursion'  => $excursion,
                    'id_usuario'    => Auth::user()->id,
                    'id_categoria'  => $categoria
                ]);
            }
        }
    }
    

    private function sincronizarItinerarios(Request $request, $excursion)
    {
        $itinerariosOriginales = array_column($excursion->itinerarios->toArray(), "dia");
        $itinerariosActualizados = range(1, $request->input("cantidad_dias"));

        $itinerariosEliminar = [];

        foreach ($itinerariosOriginales as $itinerarioOriginalDia) {
            if (!(array_search($itinerarioOriginalDia, $itinerariosActualizados) !== false)) {
                $itinerariosEliminar[] = (int) $itinerarioOriginalDia;
            }
        }

        if (count($itinerariosEliminar) > 0) {
            foreach ($excursion->itinerarios->whereIn("dia", $itinerariosEliminar) as $excursionItinerarioEliminar) {
                $excursionItinerarioEliminar->delete();
            }
        }

        foreach (range(1, $request->input("cantidad_dias")) as $i => $dia) {
            $itinerarioActual = $excursion->itinerarios->firstWhere("dia", $dia);

            if ($itinerarioActual === null) {
                // Se crea
                $itinerarioNuevo = new ExcursionItinerario();

                $itinerarioNuevo->id_empresa = Auth::user()->id_empresa;
                $itinerarioNuevo->id_usuario = Auth::user()->id;
                $itinerarioNuevo->contenido = $request->input("contenido")[$i] ?? "";
                $itinerarioNuevo->dia = $dia;

                $excursion->itinerarios()->save($itinerarioNuevo);
            } else {
                // Se actualiza 
                $itinerarioActual->contenido = $request->input("contenido")[$i];
    
                if ($itinerarioActual->isDirty()) {
                    $itinerarioActual->save();
                }
            }
        }
    }


    private function agregarCosteoRegistro(Request $request, $excursion, $idTemporada, $idClaseServicio, $tipoHabitacion) {
        $excursionCosteo = new ExcursionCosteo();

        $excursionCosteo->id_empresa                 = Auth::user()->id_empresa;
        $excursionCosteo->id_usuario                 = Auth::user()->id;
        $excursionCosteo->id_excursion               = $excursion->id;

        $excursionCosteo->id_temporada               = $idTemporada;
        $excursionCosteo->id_clase_servicio          = $idClaseServicio;
        $excursionCosteo->id_habitacion_tipo         = $tipoHabitacion;

        $costeoId = $request->input("temporada-$idTemporada-clase-$idClaseServicio-habitacion-tipo-$tipoHabitacion-costeo-id");

        if ($costeoId === null) {
            return;
        }

        $excursionCosteo->id_costeo                  = $costeoId;
        $excursionCosteo->descuento_menores          = $request->input("temporada-$idTemporada-clase-$idClaseServicio-habitacion-tipo-$tipoHabitacion-costeo-$costeoId-campo-descuento-menor") ?? "0.00";
        $excursionCosteo->descuento_menores_tipo     = ($request->input("temporada-$idTemporada-clase-$idClaseServicio-habitacion-tipo-$tipoHabitacion-costeo-$costeoId-campo-tipo-descuento-menor") === null) ? 2 : 1; // 1: Porcentaje, 2: Monto
        $excursionCosteo->descuento_infantes         = $request->input("temporada-$idTemporada-clase-$idClaseServicio-habitacion-tipo-$tipoHabitacion-costeo-$costeoId-campo-descuento-infante") ?? "0.00";
        $excursionCosteo->descuento_infantes_tipo    = ($request->input("temporada-$idTemporada-clase-$idClaseServicio-habitacion-tipo-$tipoHabitacion-costeo-$costeoId-campo-tipo-descuento-infante") === null) ? 2 : 1; // 1: Porcentaje, 2: Monto

        $excursionCosteo->save();

        $excursionCosteoCampos = $request->input("temporada-$idTemporada-clase-$idClaseServicio-habitacion-tipo-$tipoHabitacion-costeo-$costeoId-campos-id");

        $formCosteoCampos = [];
        foreach ($excursionCosteoCampos as $i => $excursionCosteoCampo) {
            $costeoCampoId = $request->input("temporada-$idTemporada-clase-$idClaseServicio-habitacion-tipo-$tipoHabitacion-costeo-$costeoId-campos-id")[$i];
            $formCosteoCampos[] = [
                'id_empresa' => Auth::user()->id_empresa,
                'id_usuario' => Auth::user()->id,
                'id_excursion_costeo' => $excursionCosteo->id,
                'id_costeo_campo' => $costeoCampoId,
                'valor' => $request->input("temporada-$idTemporada-clase-$idClaseServicio-habitacion-tipo-$tipoHabitacion-costeo-$costeoId-campo-$costeoCampoId-valor"),
            ];
        }

        $excursionCosteo->campos()->createMany($formCosteoCampos);
    }


    private function agregarTemporadaCosteo(Request $request, $excursion, $idTemporada, $idClaseServicio) {
        $tiposHabitaciones = $request->input("temporada-$idTemporada-clase-$idClaseServicio-habitaciones-tipos");

        foreach ($tiposHabitaciones as $tipoHabitacion) {
            $this->agregarCosteoRegistro($request, $excursion, $idTemporada, $idClaseServicio, $tipoHabitacion);
        }
    }


    private function agregarTemporadaCosto(Request $request, $excursion, $idTemporada, $idClaseServicio) {
        $temporadaCostoNueva = new ExcursionTemporadaCosto;

        $temporadaCostoNueva->id_empresa          = Auth::user()->id_empresa;
        $temporadaCostoNueva->id_usuario          = Auth::user()->id;
        $temporadaCostoNueva->id_excursion        = $excursion->id;
        $temporadaCostoNueva->id_temporada        = $idTemporada;
        $temporadaCostoNueva->id_clase_servicio   = $idClaseServicio;

        $temporadaCostoNueva->adulto_sencilla     = $request->input("temporada-$idTemporada-clase-$idClaseServicio-adulto_sencilla")    ?? "0.00";
        $temporadaCostoNueva->adulto_doble        = $request->input("temporada-$idTemporada-clase-$idClaseServicio-adulto_doble")       ?? "0.00";
        $temporadaCostoNueva->adulto_triple       = $request->input("temporada-$idTemporada-clase-$idClaseServicio-adulto_triple")      ?? "0.00";
        $temporadaCostoNueva->adulto_cuadruple    = $request->input("temporada-$idTemporada-clase-$idClaseServicio-adulto_cuadruple")   ?? "0.00";

        $temporadaCostoNueva->menor_sencilla      = $request->input("temporada-$idTemporada-clase-$idClaseServicio-menor_sencilla")     ?? "0.00";
        $temporadaCostoNueva->menor_doble         = $request->input("temporada-$idTemporada-clase-$idClaseServicio-menor_doble")        ?? "0.00";
        $temporadaCostoNueva->menor_triple        = $request->input("temporada-$idTemporada-clase-$idClaseServicio-menor_triple")       ?? "0.00";
        $temporadaCostoNueva->menor_cuadruple     = $request->input("temporada-$idTemporada-clase-$idClaseServicio-menor_cuadruple")    ?? "0.00";

        $temporadaCostoNueva->infante_sencilla    = $request->input("temporada-$idTemporada-clase-$idClaseServicio-infante_sencilla")   ?? "0.00";
        $temporadaCostoNueva->infante_doble       = $request->input("temporada-$idTemporada-clase-$idClaseServicio-infante_doble")      ?? "0.00";
        $temporadaCostoNueva->infante_triple      = $request->input("temporada-$idTemporada-clase-$idClaseServicio-infante_triple")     ?? "0.00";
        $temporadaCostoNueva->infante_cuadruple   = $request->input("temporada-$idTemporada-clase-$idClaseServicio-infante_cuadruple")  ?? "0.00";

        $temporadaCostoNueva->save();
    }


    private function actualizarTemporadaCosteo(Request $request, $excursion, $excursionCosteos, $idTemporada, $idClaseServicio) {
        $tiposHabitacionesOriginales = array_column($excursionCosteos->where("id_temporada", $idTemporada)->where("id_clase_servicio", $idClaseServicio)->toArray(), "id_habitacion_tipo");
        $tiposHabitacionesPeticion = $request->input("temporada-$idTemporada-clase-$idClaseServicio-habitaciones-tipos");
        $tiposHabitacionesActualizadas = [];

        foreach ($tiposHabitacionesPeticion as $tipoHabitacionPeticion) {
            if (
                ($request->input("temporada-$idTemporada-clase-$idClaseServicio-habitacion-tipo-$tipoHabitacionPeticion-costeo-id") !== null)
                && ((int) $request->input("temporada-$idTemporada-clase-$idClaseServicio-habitacion-tipo-$tipoHabitacionPeticion-costeo-id") !== 0)
            ) {
                $tiposHabitacionesActualizadas[] = $tipoHabitacionPeticion;
            }
        }

        $tiposHabitacionesActualizar = [];
        $tiposHabitacionesAgregar = [];
        $tiposHabitacionesEliminar = [];

        foreach ($tiposHabitacionesActualizadas as $idTipoHabitacionActualizada) {
            if (array_search($idTipoHabitacionActualizada, $tiposHabitacionesOriginales) !== false) {
                $tiposHabitacionesActualizar[] = $idTipoHabitacionActualizada;
            } else {
                $tiposHabitacionesAgregar[] = $idTipoHabitacionActualizada;
            }
        }

        foreach ($tiposHabitacionesOriginales as $idTipoHabitacionOriginal) {
            if (!(array_search($idTipoHabitacionOriginal, $tiposHabitacionesActualizadas) !== false)) {
                $tiposHabitacionesEliminar[] = $idTipoHabitacionOriginal;
            }
        }

        if (count($tiposHabitacionesEliminar) > 0) {
            foreach ($excursionCosteos->where("id_temporada", $idTemporada)->where("id_clase_servicio", $idClaseServicio)->whereIn("id_habitacion_tipo", $tiposHabitacionesEliminar) as $excursionCosteoEliminar) {
                //Primero eliminamos los campos relacionados
                $excursionCosteoEliminar->campos()->delete();

                // Ahora eliminamos el modelo de la relacion excursion_costeo
                $excursionCosteoEliminar->delete();
            }
        }

        foreach ($tiposHabitacionesAgregar as $idTipoHabitacionAgregar) {
            $this->agregarCosteoRegistro($request, $excursion, $idTemporada, $idClaseServicio, $idTipoHabitacionAgregar);
        }

        foreach ($tiposHabitacionesActualizar as $idTipoHabitacionActualizar) {
            $costeoModel = $excursionCosteos->where("id_temporada", $idTemporada)->where("id_clase_servicio", $idClaseServicio)->firstWhere("id_habitacion_tipo", $idTipoHabitacionActualizar);
            $costeoId = $costeoModel->id_costeo;
            
            $costeoModel->descuento_menores          = $request->input("temporada-$idTemporada-clase-$idClaseServicio-habitacion-tipo-$idTipoHabitacionActualizar-costeo-$costeoId-campo-descuento-menor") ?? "0.00";
            $costeoModel->descuento_menores_tipo     = ($request->input("temporada-$idTemporada-clase-$idClaseServicio-habitacion-tipo-$idTipoHabitacionActualizar-costeo-$costeoId-campo-tipo-descuento-menor") === null) ? 2 : 1; // 1: Porcentaje, 2: Monto
            $costeoModel->descuento_infantes         = $request->input("temporada-$idTemporada-clase-$idClaseServicio-habitacion-tipo-$idTipoHabitacionActualizar-costeo-$costeoId-campo-descuento-infante") ?? "0.00";
            $costeoModel->descuento_infantes_tipo    = ($request->input("temporada-$idTemporada-clase-$idClaseServicio-habitacion-tipo-$idTipoHabitacionActualizar-costeo-$costeoId-campo-tipo-descuento-infante") === null) ? 2 : 1; // 1: Porcentaje, 2: Monto

            if ($costeoModel->isDirty()) {
                $costeoModel->save();
            }

            $costeoModelCamposOriginales = array_column($costeoModel->campos->toArray(), "id_costeo_campo");
            $costeoModelCamposActualizados = $request->input("temporada-$idTemporada-clase-$idClaseServicio-habitacion-tipo-$idTipoHabitacionActualizar-costeo-$costeoId-campos-id");

            $camposActualizar = [];
            $camposAgregar = [];
            $camposEliminar = [];

            foreach ($costeoModelCamposActualizados as $idCampoActualizado) {
                if (array_search($idCampoActualizado, $costeoModelCamposOriginales) !== false) {
                    $camposActualizar[] = $idCampoActualizado;
                } else {
                    $camposAgregar[] = $idCampoActualizado;
                }
            }

            foreach ($costeoModelCamposOriginales as $idCampoOriginal) {
                if (!(array_search($idCampoOriginal, $costeoModelCamposActualizados) !== false)) {
                    $camposEliminar[] = $idCampoOriginal;
                }
            }

            if (count($camposEliminar) > 0) {
                foreach ($costeoModel->whereIn("id_costeo_campo", $camposEliminar) as $campoEliminar) {
                    $campoEliminar->delete();
                }
            }

            foreach ($camposAgregar as $campoAgregar) {
                $formCosteoCampoAgregar = [
                    'id_empresa' => Auth::user()->id_empresa,
                    'id_usuario' => Auth::user()->id,
                    'id_excursion_costeo' => $costeoModel->id,
                    'id_costeo_campo' => $campoAgregar,
                    'valor' => $request->input("temporada-$idTemporada-clase-$idClaseServicio-habitacion-tipo-$idTipoHabitacionActualizar-costeo-$costeoId-campo-$campoAgregar-valor"),
                ];

                ExcursionCosteoCampo::create($formCosteoCampoAgregar);
            }

            foreach ($camposActualizar as $campoActualizar) {
                $registroCosteoCampoActualizar = $costeoModel->campos->firstWhere("id_costeo_campo", $campoActualizar);
                $registroCosteoCampoActualizar->valor = $request->input("temporada-$idTemporada-clase-$idClaseServicio-habitacion-tipo-$idTipoHabitacionActualizar-costeo-$costeoId-campo-$campoActualizar-valor");
                
                if ($registroCosteoCampoActualizar->isDirty()) {
                    $registroCosteoCampoActualizar->save();
                }
            }
        }
    }


    private function actualizarTemporadaCosto(Request $request, $excursion, $excursionTemporadas, $idTemporada, $idClaseServicio) {
        $excursionTemporadaClase = $excursionTemporadas->where('id_temporada', '=', $idTemporada)->firstWhere('id_clase_servicio', '=', $idClaseServicio);

        $excursionTemporadaClase->adulto_sencilla       = $request->input("temporada-$idTemporada-clase-$idClaseServicio-adulto_sencilla")      ?? "0.00";
        $excursionTemporadaClase->adulto_doble          = $request->input("temporada-$idTemporada-clase-$idClaseServicio-adulto_doble")         ?? "0.00";
        $excursionTemporadaClase->adulto_triple         = $request->input("temporada-$idTemporada-clase-$idClaseServicio-adulto_triple")        ?? "0.00";
        $excursionTemporadaClase->adulto_cuadruple      = $request->input("temporada-$idTemporada-clase-$idClaseServicio-adulto_cuadruple")     ?? "0.00";

        $excursionTemporadaClase->menor_sencilla        = $request->input("temporada-$idTemporada-clase-$idClaseServicio-menor_sencilla")       ?? "0.00";
        $excursionTemporadaClase->menor_doble           = $request->input("temporada-$idTemporada-clase-$idClaseServicio-menor_doble")          ?? "0.00";
        $excursionTemporadaClase->menor_triple          = $request->input("temporada-$idTemporada-clase-$idClaseServicio-menor_triple")         ?? "0.00";
        $excursionTemporadaClase->menor_cuadruple       = $request->input("temporada-$idTemporada-clase-$idClaseServicio-menor_cuadruple")      ?? "0.00";

        $excursionTemporadaClase->infante_sencilla      = $request->input("temporada-$idTemporada-clase-$idClaseServicio-infante_sencilla")     ?? "0.00";
        $excursionTemporadaClase->infante_doble         = $request->input("temporada-$idTemporada-clase-$idClaseServicio-infante_doble")        ?? "0.00";
        $excursionTemporadaClase->infante_triple        = $request->input("temporada-$idTemporada-clase-$idClaseServicio-infante_triple")       ?? "0.00";
        $excursionTemporadaClase->infante_cuadruple     = $request->input("temporada-$idTemporada-clase-$idClaseServicio-infante_cuadruple")    ?? "0.00";

        if ($excursionTemporadaClase->isDirty()) {
            $excursionTemporadaClase->save();
        }
    }


    private function sincronizarTemporadas(Request $request, $excursion)
    {
        // Primero obtenemos las temporadas actuales de la excursión
        $excursionTemporadas = ExcursionTemporadaCosto::where('id_empresa', '=', Auth::user()->id_empresa)
            ->where('id_excursion', '=', $excursion->id)
            ->select()
            ->get();

        $temporadasOriginales = array_column($excursionTemporadas->toArray(), "id_temporada");
        $temporadasActualizadas = $request->input("excursion-temporadas") ?? [];

        $temporadasActualizar = [];
        $temporadasAgregar = [];
        $temporadasEliminar = [];

        foreach ($temporadasActualizadas as $idTemporadaActualizada) {
            if (array_search($idTemporadaActualizada, $temporadasOriginales) !== false) {
                $temporadasActualizar[] = (int) $idTemporadaActualizada;
            } else {
                $temporadasAgregar[] = (int) $idTemporadaActualizada;
            }
        }

        foreach ($temporadasOriginales as $temporadaOriginalId) {
            if (!(array_search($temporadaOriginalId, $temporadasActualizadas) !== false)) {
                $temporadasEliminar[] = (int) $temporadaOriginalId;
            }
        }

        // Analizar si esta bien que se eliminen los registros
        if (count($temporadasEliminar) > 0) {
            DB::table('excursiones_temporadas_costos')
                ->where('id_excursion', '=', $excursion->id)
                ->whereIn('id_temporada', $temporadasEliminar)
                ->delete();
        }

        foreach ($temporadasAgregar as $idTemporada) {
            $temporadaClasesAgregar = $request->input("excursion-temporada-$idTemporada-clases") ?? [];

            foreach ($temporadaClasesAgregar as $idTemporadaClaseAgregar) {
                $this->agregarTemporadaCosto($request, $excursion, $idTemporada, $idTemporadaClaseAgregar);
            }
        }

        foreach ($temporadasActualizar as $idTemporada) {
            $temporadaClases = $excursionTemporadas->where('id_temporada', $idTemporada);

            $temporadaClasesOriginales = array_column($temporadaClases->toArray(), "id_clase_servicio");
            $temporadaClasesActualizadas = $request->input("excursion-temporada-$idTemporada-clases") ?? [];

            $temporadaClasesActualizar = [];
            $temporadaClasesAgregar = [];
            $temporadaClasesEliminar = [];

            foreach ($temporadaClasesActualizadas as $idTemporadaClaseActualizada) {
                if (array_search($idTemporadaClaseActualizada, $temporadaClasesOriginales) !== false) {
                    $temporadaClasesActualizar[] = (int) $idTemporadaClaseActualizada;
                } else {
                    $temporadaClasesAgregar[] = (int) $idTemporadaClaseActualizada;
                }
            }
    
            foreach ($temporadaClasesOriginales as $temporadaClaseOriginalId) {
                if (!(array_search($temporadaClaseOriginalId, $temporadaClasesActualizadas) !== false)) {
                    $temporadaClasesEliminar[] = (int) $temporadaClaseOriginalId;
                }
            }

            if (count($temporadaClasesEliminar) > 0) {
                DB::table('excursiones_temporadas_costos')
                    ->where('id_excursion', '=', $excursion->id)
                    ->where('id_temporada', '=', $idTemporada)
                    ->whereIn('id_clase_servicio', $temporadaClasesEliminar)
                    ->delete();
            }

            foreach ($temporadaClasesAgregar as $idTemporadaClaseAgregar) {
                $this->agregarTemporadaCosto($request, $excursion, $idTemporada, $idTemporadaClaseAgregar);
            }

            foreach ($temporadaClasesActualizar as $idTemporadaClaseActualizar) {
                $this->actualizarTemporadaCosto($request, $excursion->id, $excursionTemporadas, $idTemporada, $idTemporadaClaseActualizar);
            }
        }
    }


    private function sincronizarCosteos(Request $request, $excursion)
    {
        // Primero obtenemos las temporadas actuales de la excursión
        $excursionCosteos = ExcursionCosteo::where('id_empresa', '=', Auth::user()->id_empresa)
            ->where("id_excursion", "=", $excursion->id)
            ->select()
            ->get();

        $temporadasOriginales = array_column($excursionCosteos->toArray(), "id_temporada");
        $temporadasActualizadas = $request->input("excursion-temporadas") ?? [];

        $temporadasActualizar = [];
        $temporadasAgregar = [];
        $temporadasEliminar = [];

        foreach ($temporadasActualizadas as $idTemporadaActualizada) {
            if (array_search($idTemporadaActualizada, $temporadasOriginales) !== false) {
                $temporadasActualizar[] = (int) $idTemporadaActualizada;
            } else {
                $temporadasAgregar[] = (int) $idTemporadaActualizada;
            }
        }

        foreach ($temporadasOriginales as $temporadaOriginalId) {
            if (!(array_search($temporadaOriginalId, $temporadasActualizadas) !== false)) {
                $temporadasEliminar[] = (int) $temporadaOriginalId;
            }
        }

        if (count($temporadasEliminar) > 0) {
            foreach ($excursionCosteos->whereIn("id_temporada", $temporadasEliminar) as $excursionCosteoEliminar) {
                //Primero eliminamos los campos relacionados
                $excursionCosteoEliminar->campos()->delete();

                // Ahora eliminamos el modelo de la relacion excursion_costeo
                $excursionCosteoEliminar->delete();
            }
        }

        foreach ($temporadasAgregar as $idTemporada) {
            $temporadaClasesAgregar = $request->input("excursion-temporada-$idTemporada-clases") ?? [];

            foreach ($temporadaClasesAgregar as $idTemporadaClaseAgregar) {
                $this->agregarTemporadaCosteo($request, $excursion, $idTemporada, $idTemporadaClaseAgregar);
            }
        }

        foreach ($temporadasActualizar as $idTemporada) {
            $temporadaClases = $excursionCosteos->where('id_temporada', $idTemporada);

            $temporadaClasesOriginales = array_column($temporadaClases->toArray(), "id_clase_servicio");
            $temporadaClasesActualizadas = $request->input("excursion-temporada-$idTemporada-clases") ?? [];

            $temporadaClasesActualizar = [];
            $temporadaClasesAgregar = [];
            $temporadaClasesEliminar = [];

            foreach ($temporadaClasesActualizadas as $idTemporadaClaseActualizada) {
                if (array_search($idTemporadaClaseActualizada, $temporadaClasesOriginales) !== false) {
                    $temporadaClasesActualizar[] = (int) $idTemporadaClaseActualizada;
                } else {
                    $temporadaClasesAgregar[] = (int) $idTemporadaClaseActualizada;
                }
            }
    
            foreach ($temporadaClasesOriginales as $temporadaClaseOriginalId) {
                if (!(array_search($temporadaClaseOriginalId, $temporadaClasesActualizadas) !== false)) {
                    $temporadaClasesEliminar[] = (int) $temporadaClaseOriginalId;
                }
            }

            if (count($temporadaClasesEliminar) > 0) {
                foreach ($excursionCosteos->where("id_temporada", $temporadasEliminar)->whereIn("id_clase_servicio", $temporadaClasesEliminar) as $excursionCosteoEliminar) {
                    //Primero eliminamos los campos relacionados
                    $excursionCosteoEliminar->campos()->delete();

                    // Ahora eliminamos el modelo de la relacion excursion_costeo
                    $excursionCosteoEliminar->delete();
                }
            }

            foreach ($temporadaClasesAgregar as $idTemporadaClaseAgregar) {
                $this->agregarTemporadaCosteo($request, $excursion, $idTemporada, $idTemporadaClaseAgregar);
            }

            foreach ($temporadaClasesActualizar as $idTemporadaClaseActualizar) {
                $this->actualizarTemporadaCosteo($request, $excursion, $excursionCosteos, $idTemporada, $idTemporadaClaseActualizar);
            }
        }
    }


    public function obtenerExcursion($idExcursion)
    {
        $excursion = Excursion::find($idExcursion);
        $this->authorize("view", $excursion);

        $idEmpresa = Auth::user()->id_empresa;

        // Ahora pasamos a las imágenes y los itinerarios
        $imagenes = ExcursionesImagenes::where("id_empresa", "=", $idEmpresa)
            ->where('id_excursion', '=', $idExcursion)
            ->select()
            ->get();

        $itinerarios = ExcursionItinerario::where('id_excursion', '=', $idExcursion)
            ->select()
            ->get();

        $promocion = ExcursionPromocion::where('id_excursion', '=', $idExcursion)
            ->select()
            ->get();

        $validity = false;
        $reason = "";

        $moneda = Moneda::find($excursion->id_moneda);

        //////////////////////////////////////////////////////////
        // Ahora obtenemos todos los datos de esta excursion y  //
        // su relación con las tablas obtenidas anteriormente   //
        //////////////////////////////////////////////////////////

        // Excursiones incluye
        $excursionesIncluye  = ExcursionIncluye::where('id_excursion', '=', $idExcursion)
            ->select('id', 'id_incluye')
            ->get()
            ->toArray();

        $incluye = new Collection(array_column($excursionesIncluye, "id_incluye"));

        // Excursiones NO Incluye
        $excursionNoIncluye = ExcursionNoIncluye::where('id_excursion', '=', $idExcursion)
            ->select('id', 'id_no_incluye')
            ->get()
            ->toArray();

        $noIncluye = new Collection(array_column($excursionNoIncluye, "id_no_incluye"));

        //Excursiones categorías
        $excursionesCategoria = ExcursionCategoria::where('id_excursion', '=', $idExcursion)
            ->select('id', 'id_categoria')
            ->get()
            ->toArray();

        $categorias = new Collection(array_column($excursionesCategoria, "id_categoria"));

        //Excursiones recomendaciones
        $excursionesRecomendacion = ExcursionRecomendacion::where('id_excursion', '=', $idExcursion)
            ->select('id', 'id_recomendacion')
            ->get()
            ->toArray();

        $recomendaciones = new Collection(array_column($excursionesRecomendacion, "id_recomendacion"));

        // Excursiones temporadas costos
        $costos = ExcursionTemporadaCosto::leftJoin('clases_servicios', 'excursiones_temporadas_costos.id_clase_servicio', '=', 'clases_servicios.id')
            ->where('id_excursion', '=', $idExcursion)
            ->select(['excursiones_temporadas_costos.*', 'clases_servicios.nombre as nombre_clase_servicio'])
            ->get();

        return response()->json([
            'code' => '200',
            'body' => compact(
                'excursion',
                'imagenes',
                'itinerarios',
                'costos',
                'incluye',
                'noIncluye',
                'categorias',
                'recomendaciones',
                'promocion',
                'moneda',
            )
        ]);
    }


    public function obtenerTemporadasExcursion(Request $request, $idExcursion)
    {
        DB::statement("SET SQL_MODE=''");

        $temporadas = ExcursionTemporadaCosto::leftJoin("temporadas", "excursiones_temporadas_costos.id_temporada", "=", "temporadas.id")
            ->where("excursiones_temporadas_costos.id_excursion", "=", $idExcursion)
            ->select(
                [
                    "temporadas.id",
                    "temporadas.nombre",
                ]
            )
            ->groupBy('temporadas.id')
            ->orderBy('temporadas.nombre', 'asc')
            ->get();

        return response()->json([
            'code' => '200',
            'body' => [
                "temporadas" => $temporadas,
            ]
        ]);
    }
    

    public function obtenerClasesExcursionTemporada(Request $request, $idExcursion, $idTemporada)
    {
        DB::statement("SET SQL_MODE=''");

        $clases = ExcursionTemporadaCosto::leftJoin("clases_servicios", "excursiones_temporadas_costos.id_clase_servicio", "=", "clases_servicios.id")
            ->where("excursiones_temporadas_costos.id_excursion", "=", $idExcursion)
            ->where("excursiones_temporadas_costos.id_temporada", "=", $idTemporada)
            ->select(
                [
                    "clases_servicios.id",
                    "clases_servicios.nombre",
                ]
            )
            ->groupBy('clases_servicios.id')
            ->orderBy('clases_servicios.nombre', 'asc')
            ->get();

        return response()->json([
            'code' => '200',
            'body' => [
                "clases" => $clases,
            ]
        ]);
    }


    public function obtenerPreciosExcursion(Request $request, $idExcursion)
    {
        $precios = null;

        if ($request->query("fechas")) {
            $fechas = $request->query("fechas");
            list($fechaInicio, $fechaFin) = explode(",", $fechas);

            $precios = ExcursionTemporadaCosto::leftJoin("excursiones_fechas", "excursiones_temporadas_costos.id", "=", "excursiones_fechas.id_temporada_costo")
                ->where("excursiones_fechas.fecha_inicio", "=", $fechaInicio)
                ->where("excursiones_fechas.fecha_fin", "=", $fechaFin)
                ->select("excursiones_temporadas_costos.*")
                ->first();
        } else if (($request->query("temporada")) && ($request->query("clase_servicio"))) {
            $idTemporada = $request->query("temporada");
            $idClaseServicio = $request->query("clase_servicio");

            $precios = ExcursionTemporadaCosto::where("id_excursion", "=", $idExcursion)
                ->where("id_temporada", "=", $idTemporada)
                ->where("id_clase_servicio", "=", $idClaseServicio)
                ->select()
                ->first();
        }

        return response()->json([
            'code' => '200',
            'body' => [
                "precios" => $precios,
            ]
        ]);
    }
}
