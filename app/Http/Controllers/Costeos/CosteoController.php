<?php

namespace App\Http\Controllers\Costeos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Costeos\APICosteoController;
use App\Models\Costeos\Costeo;

use App\Http\Helpers\StringHelper;

class CosteoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        $costeos = Costeo::where("id_empresa", "=", Auth::user()->id_empresa)
            ->select()
            ->with("condiciones")
            ->withCount("campos")
            ->get();

        return view('costeos.index', compact(
            'costeos',
        ));
    }


    public function show(Request $request, $idCosteo)
    {
        $api = filter_var($request->query("api", ($request["api"] ?? false)), FILTER_VALIDATE_BOOLEAN);
        
        if ($api === true) {
            $request->merge([
                "apiKey" => ["business" => (object) ["id" => Auth::user()->id_empresa]],
                "json" => true,
            ]);
    
            return APICosteoController::show($request, null, $idCosteo);
        }
    }


    public function create(){
        return view('costeos.agregar');
    }


    public function store(Request $request)
    {
        $request["id_empresa"]          = Auth::user()->id_empresa;
        $request["id_usuario"]          = Auth::user()->id;
        $request["id_tipo_excursion"]   = 0;
        $request["id_temporada"]        = 0;
        $request["id_clase_servicio"]   = 0;
        // $request["formula_precio"] = StringHelper::sanitizarInputFormulaCosteo($request->input("costeo-campos-nombres"), $request->input("formula_precio"));
        $request["formula_precio_nueva"] = StringHelper::sanitizarInputFormulaCosteo($request->input("costeo-campos-nombres"), $request->input("formula_precio"));

        $costeo = Costeo::create($request->all());

        // CAMPOS
        // Ahora se procesan los campos asociados
        $arrCampos = [];

        foreach ($request->input("costeo-campos-nombres") as $i => $campoNombre) {
            $definidoPorUsuario = $request->input("costeo-campos-dpu")[$i];
            $definidoPorExcursion = 0;
            $excursionColumna = "";

            if ($campoNombre === "CANTIDAD_PASAJEROS") {
                $definidoPorUsuario = 1;
            } else if ($campoNombre === "CANTIDAD_PASAJEROS_GRUPO") {
                $definidoPorUsuario = 0;
                $definidoPorExcursion = 1;
                $excursionColumna = "cantidad_pasajeros_grupo";
            }

            $arrCampos[] = [
                "id_empresa"                => Auth::user()->id_empresa,
                "id_usuario"                => Auth::user()->id,
                "nombre"                    => $request->input("costeo-campos-nombres")[$i],
                "identificador"             => StringHelper::crearIdentificadorCampoCosteo($campoNombre),
                "valor_defecto"             => $request->input("costeo-campos-valores-por-defecto")[$i],
                "definido_por_usuario"      => $definidoPorUsuario,
                "definido_por_excursion"    => $definidoPorExcursion,
                "excursion_columna"         => $excursionColumna,
            ];
        }

        $costeo->campos()->createMany($arrCampos);

        // CONDICIONES
        // Ahora se procesan las condiciones asociadas
        $arrCondiciones = [];

        foreach ($request->input("costeo-condiciones") ?? [] as $i => $condicion) {
            $arrCondiciones[] = [
                "id_empresa"        => Auth::user()->id_empresa,
                "id_usuario"        => Auth::user()->id,
                "condicion"         => StringHelper::sanitizarInputFormulaCosteo($request->input("costeo-campos-nombres"), $request->input("costeo-condiciones")[$i]),
                "formula_precio"    => StringHelper::sanitizarInputFormulaCosteo($request->input("costeo-campos-nombres"), $request->input("costeo-condiciones-formulas")[$i]),
            ];
        }

        $costeo->condiciones()->createMany($arrCondiciones);

        return redirect()->route('costeos.index')->with('message', "El costeo y sus asociaciones se han creado con éxito.");
    }


    public function edit(Costeo $costeo)
    {
        return view('costeos.editar', compact('costeo'));
    }


    public function update(Request $request, Costeo $costeo)
    {
        $request["formula_precio"] = StringHelper::sanitizarInputFormulaCosteo($request->input("costeo-campos-nombres"), $request->input("formula_precio"));
        $costeo->update($request->all());

        // CAMPOS
        // Se actualizan y en caso de haber nuevos campos se agregan a la base de datos
        $arrCamposNuevos = [];
        foreach ($request->input("costeo-campos-id") as $i => $campoId) {
            $costeoEditar = $costeo->campos->firstWhere("id", "=", $campoId);

            $definidoPorUsuario = $request->input("costeo-campos-dpu")[$i];
            $definidoPorExcursion = 0;
            $excursionColumna = "";

            if ($request->input("costeo-campos-nombres")[$i] === "CANTIDAD_PASAJEROS") {
                $definidoPorUsuario = 1;
            } else if ($request->input("costeo-campos-nombres")[$i] === "CANTIDAD_PASAJEROS_GRUPO") {
                $definidoPorUsuario = 0;
                $definidoPorExcursion = 1;
                $excursionColumna = "cantidad_pasajeros_grupo";
            }

            if (!$costeoEditar) {
                $arrCamposNuevos[] = [
                    "id_empresa"                => Auth::user()->id_empresa,
                    "id_usuario"                => Auth::user()->id,
                    "nombre"                    => $request->input("costeo-campos-nombres")[$i],
                    "identificador"             => StringHelper::crearIdentificadorCampoCosteo($request->input("costeo-campos-nombres")[$i]),
                    "valor_defecto"             => $request->input("costeo-campos-valores-por-defecto")[$i],
                    "definido_por_usuario"      => $definidoPorUsuario,
                    "definido_por_excursion"    => $definidoPorExcursion,
                    "excursion_columna"         => $excursionColumna,
                ];

                continue;
            }

            $costeoEditar->nombre                   = $request->input("costeo-campos-nombres")[$i];
            $costeoEditar->identificador            = StringHelper::crearIdentificadorCampoCosteo($request->input("costeo-campos-nombres")[$i]);
            $costeoEditar->valor_defecto            = $request->input("costeo-campos-valores-por-defecto")[$i];
            $costeoEditar->definido_por_usuario     = $definidoPorUsuario;
            $costeoEditar->definido_por_excursion   = $definidoPorExcursion;
            $costeoEditar->excursion_columna        = $excursionColumna;

            if ($costeoEditar->isDirty()) {
                $costeoEditar->save();
            }
        }

        if (count($arrCamposNuevos) > 0) {
            $costeo->campos()->createMany($arrCamposNuevos);
        }

        // CONDICIONES
        // Ahora se actualizan las condiciones asociadas
        $arrCondicionesNuevas = [];
        foreach ($request->input("costeo-condiciones-id") ?? [] as $i => $condicionId) {
            $condicionEditar = $costeo->condiciones->firstWhere("id", "=", $condicionId);

            if (!$condicionEditar) {
                $arrCondicionesNuevas[] = [
                    "id_empresa"        => Auth::user()->id_empresa,
                    "id_usuario"        => Auth::user()->id,
                    "condicion"         => StringHelper::sanitizarInputFormulaCosteo($request->input("costeo-campos-nombres"), $request->input("costeo-condiciones")[$i]),
                    "formula_precio"    => StringHelper::sanitizarInputFormulaCosteo($request->input("costeo-campos-nombres"), $request->input("costeo-condiciones-formulas")[$i]),
                ];

                continue;
            }

            $condicionEditar->condicion         = StringHelper::sanitizarInputFormulaCosteo($request->input("costeo-campos-nombres"), $request->input("costeo-condiciones")[$i]);
            $condicionEditar->formula_precio    = StringHelper::sanitizarInputFormulaCosteo($request->input("costeo-campos-nombres"), $request->input("costeo-condiciones-formulas")[$i]);

            if ($condicionEditar->isDirty()) {
                $condicionEditar->save();
            }
        }

        $costeo->condiciones()->createMany($arrCondicionesNuevas);

        return redirect()->route('costeos.index')->with('message', "Se ha actualizado correctamente el costeo: " .  $costeo->nombre);
    }
}
