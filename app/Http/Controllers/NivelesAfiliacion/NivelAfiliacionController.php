<?php

namespace App\Http\Controllers\NivelesAfiliacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\NivelesAfiliacion\NivelAfiliacion;

class NivelAfiliacionController extends Controller
{
    public function index(){
        $niveles = NivelAfiliacion::where('id_empresa', '=', Auth::user()->id_empresa)->select('*')->get();
        $cniveles = NivelAfiliacion::where('id_empresa', '=', Auth::user()->id_empresa)->select('*')->get()->count();
        return view('afiliadosniveles.index', compact('niveles', 'cniveles'));
    }

    public function create(){
        return view('afiliadosniveles.agregar');
    }

    public function store(Request $request){
        $form = $request->all();
        $form["id_empresa"] = Auth::user()->id_empresa;
        $form["id_usuario"] = Auth::user()->id;
        NivelAfiliacion::create($form);
        return redirect()->route('nivelafiliacion.index')->with('message', 'Nivel agregado correctamente');
    }

    public function edit($id){
        $nivel = NivelAfiliacion::find($id);
        return view('afiliadosniveles.editar', compact('nivel'));
    }

    public function update(Request $request){
        $idnivel = $request->idnivel;
        $afiliacion = NivelAfiliacion::find($idnivel);
        $afiliacion->nombre = $request->input('nombre');
        $afiliacion->comision = $request->input('comision');
        $afiliacion->save();
        return redirect()->route('nivelafiliacion.index')->with('message', 'Nivel editado correctamente');
    }

    public function destroy(Request $request, $id){
        $idnivel = NivelAfiliacion::find($id);
        $idnivel->delete();
        //Falta validar si el tipo de tour es usado, si es usado no debe permitirse eliminar
    }
}
