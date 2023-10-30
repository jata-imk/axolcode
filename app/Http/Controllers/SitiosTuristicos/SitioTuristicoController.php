<?php

namespace App\Http\Controllers\SitiosTuristicos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Empresas\Empresa;
use App\Models\SitiosTuristicos\SitioTuristico;
use App\Http\Controllers\SitiosTuristicos\APISitioTuristicoController;
use App\Http\Controllers\SitiosTuristicos\Imagenes\SitioTuristicoImagenController;
use App\Models\SitiosTuristicos\Imagenes\SitioTuristicoImagen;

class SitioTuristicoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request["apiKey"] = ["business" => (object) ["id" => Auth::user()->id_empresa]];        
        $request["json"] = false;

        if ($request->query("api")) {
            if ($request->query("api") == "true") {
                $request["json"] = true;
                return APISitioTuristicoController::index($request);
            }
        }

        $sitios = APISitioTuristicoController::index($request);
        $miEmpresa = Empresa::find(Auth::user()->id_empresa);

        return view('sitios_turisticos.index', compact(
            'miEmpresa',
            'sitios'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('sitios_turisticos.agregar');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $form = $request->all();
        $form["id_empresa"] = Auth::user()->id_empresa;
        $form["id_usuario"] = Auth::user()->id;

        $sitioTuristico = SitioTuristico::create($form);

        if ($request->hasFile('file')) {
            $request->merge([
                "controller" => true,
            ]);

            $sitioTuristicoImagenes = SitioTuristicoImagenController::store($request, $sitioTuristico->id);
        }

        if (($request->query("api")) && ($request->query("api") == true)) {
            $sitioTuristico->imagenes;

            return response()->json([
                'code' => '201',
                'body' => [
                    "sitioTuristico" => $sitioTuristico,
                ]
            ]);
        } else {
            return redirect()->route('sitios-turisticos.index')->with('message', 'Sitio turístico agregado correctamente');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($sitioId)
    {
        $sitio = SitioTuristico::find($sitioId);

        return view('sitios_turisticos.editar', compact(
            'sitio'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $sitioId)
    {
        $sitio = SitioTuristico::find($sitioId);

        //Guardar cambios
        $sitio->update($request->all());

        return redirect()->route('sitios-turisticos.index')->with('message', 'Sitio turístico editado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
