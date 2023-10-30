<?php

namespace App\Http\Controllers\Promociones;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Promociones\Promocion;
use App\Models\ExcursionesPromociones\ExcursionPromocion;

class PromocionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $this->authorize("viewAny", Promocion::class);

        $promociones = Promocion::where('id_empresa', '=', Auth::user()->id_empresa)
            ->select()
            ->get();

        $cpromociones = Promocion::where('id_empresa', '=', Auth::user()->id_empresa)
            ->select()
            ->get()
            ->count();

        return view('promociones.index', compact(
            'promociones',
            'cpromociones'
        ));
    }

    public function create() {
        $this->authorize("create", Promocion::class);

        return view('promociones.agregar');
    }

    public function store(Request $request) {
        $this->authorize("create", Promocion::class);

        $form = $request->all();

        $form["id_empresa"] = Auth::user()->id_empresa;
        $form["id_usuario"] = Auth::user()->id;

        Promocion::create($form);

        return redirect()->route('promociones.index')->with('message', 'Promoción agregada correctamente');
    }

    public function show($id) {
        $promocion = Promocion::find($id);

        $this->authorize("view", $promocion);

        return $promocion;
    }

    public function edit($id){
        $promocion = Promocion::find($id);

        $this->authorize("view", $promocion);

        return view('promociones.editar', compact(
            'promocion'
        ));
    }

    public function update(Request $request, $idPromocion){
        $promocion = Promocion::find($idPromocion);

        $this->authorize("update", $promocion);

        $promocion->update($request->all());

        return redirect()->route('promociones.index')->with('message', 'Promoción editada correctamente');
    }

    public function destroy(Request $request, $idPromocion){
        $promocion = Promocion::find($idPromocion);

        $this->authorize("delete", $promocion);

        $promocion->delete();

        return response()->json([
            'code' => '200',
            'body' => [
                "msg" => "",
            ]
        ], 200);
    }

    public function validarPromocion(Request $request)
    {
        // Aqui se valida la promoción
        $idExcursion = $request->input("id_excursion");
        $idPromocion = $request->input("id_promocion");

        ExcursionPromocion::where("id_excursion", "=", $idExcursion)
            ->where("id_promocion", "=", $idPromocion)
            ->select()
            ->first();
    }
}
