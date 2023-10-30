<?php

namespace App\Http\Controllers\Recomendaciones;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\Recomendaciones\Recomendacion;

class RecomendacionController extends Controller
{
    public function index()
    {
        $recomendaciones = Recomendacion::where('id_empresa', '=', Auth::user()->id_empresa)
            ->select()
            ->get();

        return view('recomendaciones.index', compact(
            'recomendaciones',
        ));
    }


    public function create()
    {
        return view('recomendaciones.agregar');
    }


    public function store(Request $request)
    {
        $form = $request->all();

        $form["id_empresa"]     = Auth::user()->id_empresa;
        $form["id_usuario"]     = Auth::user()->id;

        $form["descripcion"]    = $request->input("descripcion") ?? "";
        $form["icono"]          = $request->input("icono") ?? "";

        $recomendacion = Recomendacion::create($form);

        $api = filter_var($request->query("api", ($request["api"] ?? false)), FILTER_VALIDATE_BOOLEAN);
        if ($api) {
            return response()->json([
                'code' => '201',
                'body' => [
                    "recomendacion" => $recomendacion,
                ]
            ]);
        } else {
            return redirect()->route('recomendaciones.index')->with('message', 'Recomendación agregado correctamente');
        }
    }


    public function edit(Request $request, $idRecomendacion)
    {
        $recomendacion = Recomendacion::find($idRecomendacion);

        return view('recomendaciones.editar', compact(
            'recomendacion'
        ));
    }

    public function update(Request $request, $idRecomendacion)
    {
        $recomendacion = Recomendacion::find($idRecomendacion);
        
        $form = $request->all();

        $form["descripcion"]    = $request->input("descripcion") ?? "";
        $form["icono"]          = $request->input("icono") ?? "";

        $recomendacion->update($form);

        return redirect()->route('recomendaciones.index')->with('message', 'Recomendación editada correctamente');
    }


    public function destroy(Request $request, $idRecomendacion)
    {
        $recomendacion = Recomendacion::find($idRecomendacion);
        $recomendacion->delete();
    }
}
