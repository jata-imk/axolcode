<?php

namespace App\Http\Controllers\Servicios;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Servicios\Servicio;

class ServicioController extends Controller
{
    public function index(){
        $servicios = Servicio::where('id_empresa', '=', Auth::user()->id_empresa)->select('*')->get();
        $cservicio = Servicio::where('id_empresa', '=', Auth::user()->id_empresa)->select('*')->get()->count();
        return view('servicios.index', compact('servicios', 'cservicio'));
    }

    public function create(){
        return view('servicios.agregar');
    }

    public function store(Request $request) {
        $form = $request->all();

        $form["id_empresa"] = Auth::user()->id_empresa;
        $form["id_usuario"] = Auth::user()->id;
        
        $servicio = Servicio::create($form);
        
        $api = filter_var($request->query("api", ($request["api"] ?? false)), FILTER_VALIDATE_BOOLEAN);
        if ($api) {
            return response()->json([
                'code' => '201',
                'body' => [
                    "servicio" => $servicio,
                ]
            ]);
        } else {
            return redirect()->route('servicios.index')->with('message', 'Servicio agregado correctamente');
        }
    }

    public function edit(Servicio $servicio) {
        return view('servicios.editar', compact('servicio'));
    }

    public function update(Request $request, Servicio $servicio){
        //Guardar cambios de un tipop de tour
        $servicio->update($request->all());
        return redirect()->route('servicios.index')->with('message', 'Servicio editado correctamente');
    }

    public function destroy(Request $request, Servicio $servicio){
        $idservicio = $servicio->id;
        $servicio->delete();
        //Falta validar si el tipo de tour es usado, si es usado no debe permitirse eliminar
    }
}
