<?php

namespace App\Http\Controllers\Monedas;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Monedas\Moneda;

class MonedaController extends Controller
{
    public function index()
    {
        $monedas = Moneda::where('id_empresa', '=', Auth::user()->id_empresa)->select('*')->get();
        $cmonedas = Moneda::where('id_empresa', '=', Auth::user()->id_empresa)->select('*')->get()->count();
        return view('monedas.index', compact('monedas', 'cmonedas'));
    }

    public function create(){
        return view('monedas.agregar');
    }

    public function store(Request $request){
        $form = $request->all();
        $form["id_empresa"] = Auth::user()->id_empresa;
        $form["id_usuario"] = Auth::user()->id;
        Moneda::create($form);
        return redirect()->route('monedas.index')->with('message', 'Moneda agregada correctamente');
    }

    public function edit(Moneda $moneda){
        return view('monedas.editar', compact('moneda'));
    }

    public function update(Request $request, Moneda $moneda){
        $moneda->update($request->all());
        return redirect()->route('monedas.index')->with('message', 'Moneda actualizada con éxito');
    }

    public function destroy(Request $request, Moneda $moneda){
        $idmoneda = $moneda->id;
        $moneda->delete();
        //Falta validar si el tipo de tour es usado, si es usado no debe permitirse eliminar
    }
}
