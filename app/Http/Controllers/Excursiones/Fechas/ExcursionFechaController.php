<?php

namespace App\Http\Controllers\Excursiones\Fechas;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Excursiones\Excursion;
use App\Models\Excursiones\TemporadasCostos\ExcursionTemporadaCosto;
use App\Models\Excursiones\Fechas\ExcursionFecha;

use App\Http\Controllers\Excursiones\Fechas\APIExcursionFechaController;

class ExcursionFechaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index(Request $request)
    {
        $excursiones = Excursion::leftJoin("tipos", "excursiones.id_tipo", "=", "tipos.id")
            ->where("excursiones.id_empresa", "=", Auth::user()->id_empresa)
            ->where("excursiones.calendario", "=", 1)
            ->select(
                [
                    "excursiones.id",
                    "excursiones.nombre",
                    "excursiones.cantidad_dias",
                    DB::raw("(SELECT path FROM excursiones_imagenes WHERE id_excursion = excursiones.id AND principal_tarjetas = 1) AS path"),
                    "tipos.nombre as tipo_nombre"    
                ]
            )
            ->get();

        // TODO: Mejorar la consulta anterior para que aun sin tener una imagen principal la excursion se haga el left join

        $fechasExcursion = null;
        $excursion = null;
        $temporadas = null;
        $fechas = null;

        $idExcursion = $request->query("excursion");

        if ($idExcursion !== null) {
            $fechasExcursion = $this->obtenerFechasExcursion($request, $idExcursion, ["api" => false]);
            
            $excursion =  $fechasExcursion["excursion"];
            $temporadas =  $fechasExcursion["temporadas"];
            $fechas =  $fechasExcursion["fechas"];
        }

        return view('excursiones.fechas.index', compact(
            'excursiones',
            'excursion',
            'temporadas',
            'fechas'
        ));
    }


    public function create()
    {
        $excursiones = Excursion::leftJoin("tipos", "excursiones.id_tipo", "=", "tipos.id")
            ->where("excursiones.id_empresa", "=", Auth::user()->id_empresa)
            ->where("excursiones.calendario", "=", 1)
            ->select([  "excursiones.id",
                        "excursiones.nombre",
                    ])
            ->get();

        return view('excursiones.fechas.agregar', compact(
            'excursiones',
        ));
    }


    public function store(Request $request)
    {
        $excursionTemporadaCostos = ExcursionTemporadaCosto::where("id_excursion", "=", $request->input("id_excursion"))
            ->select([
                "id",
                "id_excursion",
                "id_temporada",
                "id_clase_servicio",
            ])
            ->get();

        $rowsFechas = [];
        $temporadas = $request->input("temporadas");
        foreach ($temporadas as $idTemporada) {
            $fechas = $request->input("temporada-$idTemporada-id");

            foreach ($fechas as $idFecha) {
                $fechaInicio = $request->input("temporada-$idTemporada-$idFecha-fecha-inicio");
                $fechaFin = $request->input("temporada-$idTemporada-$idFecha-fecha-fin");
                $fechaCupo = $request->input("temporada-$idTemporada-$idFecha-cupo");
                $fechaPublicarFecha = $request->input("temporada-$idTemporada-$idFecha-publicar-fecha") ?? 0;
                $fechaIdClases = $request->input("temporada-$idTemporada-$idFecha-clases");

                foreach ($fechaIdClases as $idClase) {
                    $fechaTemporadaCostoId = $excursionTemporadaCostos->where("id_temporada", "=", $idTemporada)->firstWhere("id_clase_servicio", "=", $idClase)->id;
    
                    $rowsFechas[] = [
                        "id_empresa" => Auth::user()->id_empresa,
                        "id_usuario" => Auth::user()->id,
                        "id_temporada_costo" => $fechaTemporadaCostoId,
                        "fecha_inicio" => $fechaInicio,
                        "fecha_fin" => $fechaFin,
                        "cupo" => $fechaCupo,
                        "publicar_fecha" => $fechaPublicarFecha,
                        "created_at" => date("Y-m-d H:i:s"),
                        "updated_at" => date("Y-m-d H:i:s"),
                    ];
                }
            }
        }

        ExcursionFecha::insert($rowsFechas);

        return redirect()->route('excursiones-fechas.index', ['excursion' => $request->id_excursion])->with('message', "La(s) fecha(s) se ha(n) agregado con éxito.");
    }

    
    public function editarExcursionFecha(Request $request, $idExcursion, $fechas)
    {
        $excursion = Excursion::where("id", "=", $idExcursion)
            ->select(
                [
                    "id",
                    "nombre"
                ]
            )
            ->get();

        list($fechaInicio, $fechaFin) = explode(",", $fechas);

        $request->merge([
            "apiKey" => ["business" => (object) ["id" => Auth::user()->id_empresa]],
            "json" => false,
            "fecha-inicio" => $fechaInicio,
            "fecha-fin" => $fechaFin,
        ]);
        $fecha = APIExcursionFechaController::index($request, null, $idExcursion)[0];

        return view('excursiones.fechas.editar', compact(
            'excursion',
            'fecha',
        ));
    }


    public function edit($id)
    {
        $fecha = ExcursionFecha::leftJoin("excursiones_temporadas_costos", "excursiones_fechas.id_temporada_costo", "=", "excursiones_temporadas_costos.id")
            ->leftJoin("temporadas", "excursiones_temporadas_costos.id_temporada", "=", "temporadas.id")
            ->leftJoin("clases_servicios", "excursiones_temporadas_costos.id_clase_servicio", "=", "clases_servicios.id")
            ->leftJoin("excursiones", "excursiones_temporadas_costos.id_excursion", "=", "excursiones.id")
            ->where("excursiones_fechas.id", "=", $id)
            ->select(
                [
                    "excursiones.id as excursion_id",
                    "excursiones.nombre as excursion_nombre",
                    "temporadas.id as temporada_id",
                    "temporadas.nombre as temporada_nombre",
                    "clases_servicios.id as clase_servicio_id",
                    "clases_servicios.nombre as clase_servicio_nombre",
                    "excursiones_fechas.*"
                ]
            )
            ->first();

        return view('excursiones.fechas.editar', compact(
            'fecha',
        ));
    }


    public function actualizarExcursionFecha(Request $request, $idExcursion, $fechas) {
        list($fechaInicio, $fechaFin) = explode(",", $fechas);

        $request->merge([
            "apiKey" => ["business" => (object) ["id" => Auth::user()->id_empresa]],
            "json" => false,
            "fecha-inicio" => $fechaInicio,
            "fecha-fin" => $fechaFin,
        ]);
        $registrosFecha = APIExcursionFechaController::index($request, null, $idExcursion)[0];
        
        foreach ($registrosFecha->clases as $clase) {
            $cupo = $request->input("temporada-{$registrosFecha->temporada->id}-clase-{$clase->id}-cupo");
            $publicar = ( array_search($clase->id, $request->input("temporada-{$registrosFecha->temporada->id}-clases") ?? []) !== false) ? 1 : 0;

            ExcursionFecha::leftJoin("excursiones_temporadas_costos", "excursiones_fechas.id_temporada_costo", "=", "excursiones_temporadas_costos.id")
            ->where('excursiones_temporadas_costos.id_temporada', $registrosFecha->temporada->id)
            ->where('excursiones_temporadas_costos.id_clase_servicio', $clase->id)
            ->where('excursiones_fechas.fecha_inicio', $fechaInicio)
            ->where('excursiones_fechas.fecha_fin', $fechaFin)
            ->update(
                [
                    'cupo' => $cupo,
                    'publicar_fecha' => $publicar,
                ]
            );
        }

        return redirect()->route('excursiones-fechas.index', ["excursion" => $request->excursion_id])->with('message', "La fecha se ha actualizado satisfactoriamente.");
    }


    public function update(Request $request, $id)
    {
        $fecha = ExcursionFecha::find($id);

        $fecha->update($request->only(["cupo", "publicar_fecha"]));

        return redirect()->route('excursiones-fechas.index', ["excursion" => $request->excursion_id])->with('message', "La fecha se ha actualizado satisfactoriamente.");
    }


    public function destroy($idFecha)
    {
        $fecha = ExcursionFecha::find($idFecha);
        $fecha->delete();
    }


    public function obtenerFechasExcursion(Request $request, $idExcursion, $options = [])
    {
        $excursion = Excursion::where("id", "=", $idExcursion)
            ->select(
                [
                    "id",
                    "nombre",
                    "calendario",
                ]
            )
            ->get();

        $request->merge([
            "apiKey" => ["business" => (object) ["id" => Auth::user()->id_empresa]],
            "json" => false,
        ]);
        $fechas = APIExcursionFechaController::index($request, null, $idExcursion);

        $temporadasArr = array_column($fechas->toArray(), "temporada");
        
        $temporadas = [];
        $temporadas["id"] = array_values(array_unique(array_column($temporadasArr, "id")));
        $temporadas["nombre"] = array_values(array_unique(array_column($temporadasArr, "nombre")));

        if (($options["api"] ?? true) === false) {
            return [
                "excursion" => $excursion,
                "fechas" => $fechas,
                "temporadas" => $temporadas,
            ];
        }

        return response()->json([
            'code' => '200',
            'body' => [
                "excursion" => $excursion,
                "fechas" => $fechas,
                "temporadas" => $temporadas,
            ]
        ]);
    }
}
