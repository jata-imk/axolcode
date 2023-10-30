<?php

namespace App\Http\Controllers\Temporadas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Temporadas\Temporada;

class TemporadaController extends Controller
{
    public function index()
    {
        $temporadas = Temporada::where('id_empresa', '=', Auth::user()->id_empresa)
            ->select()
            ->get();

        return view('temporadas.index', compact('temporadas'));
    }

    public function create()
    {
        return view('temporadas.agregar');
    }

    public function store(Request $request)
    {
        $form = $request->all();
        $form["id_empresa"] = Auth::user()->id_empresa;
        $form["id_usuario"] = Auth::user()->id;
        Temporada::create($form);
        return redirect()->route('temporadas.index')->with('message', 'Temporada agregada correctamente');
    }


    public function edit(Temporada $temporada)
    {
        return view('temporadas.editar', compact('temporada'));
    }


    public function update(Request $request, Temporada $temporada)
    {
        //Guardar cambios de un tipop de tour
        $temporada->update($request->all());
        
        return redirect()->route('temporadas.index')->with('message', 'Temporada editada correctamente');
    }

    public function destroy(Request $request, Temporada $temporada)
    {
        $idtemporada = $temporada->id;
        $temporada->delete();
        //Falta validar si el tipo de tour es usado, si es usado no debe permitirse eliminar
    }
}
