<?php

namespace App\Http\Controllers\Tipos;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use App\Models\Tipos\Tipo;

use Illuminate\Http\Request;

class TipoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $tipos = Tipo::where('id_empresa', '=', Auth::user()->id_empresa)
            ->select()
            ->get();

        return view('tipos.index', compact(
            'tipos'
        ));
    }

    public function create()
    {
        return view('tipos.agregar');
    }

    public function store(Request $request)
    {
        $form = $request->all();
        
        $form["id_empresa"] = Auth::user()->id_empresa;
        $form["id_usuario"] = Auth::user()->id;

        Tipo::create($form);

        return redirect()->route('tipos.index')->with('message', 'Tipo de tour agregado correctamente');
    }

    public function edit($idTipoTour)
    {
        $tipoTour = Tipo::find($idTipoTour);

        return view('tipos.editar', compact('tipoTour'));
    }

    public function update(Request $request, $idTipoTour)
    {
        $tipoTour = Tipo::find($idTipoTour);

        // Guardar cambios de un tipo de tour
        $tipoTour->update($request->all());

        return redirect()->route('tipos.index')->with('message', 'Tipo de tour editado correctamente');
    }

    public function destroy(Request $request, $idTipoTour)
    {
        $tipoTour = Tipo::find($idTipoTour);

        // Falta validar si el tipo de tour es usado, si es usado no debe permitirse eliminar
        // $tipoTour->delete();
    }
}
