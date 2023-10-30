<?php

namespace App\Http\Controllers\SitiosTuristicos\Imagenes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\SitiosTuristicos\SitioTuristico;
use App\Models\SitiosTuristicos\Imagenes\SitioTuristicoImagen;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class SitioTuristicoImagenController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($idSitioTuristico)
    {
        $sitioTuristicoImagenes = SitioTuristicoImagen::where('id_sitio_turistico', '=', $idSitioTuristico)
            ->select()
            ->get();
        
        return response()->json([
            'code' => '200',
            'body' => [
                "imagenes" => $sitioTuristicoImagenes,
            ]
        ]);
    }

    public static function store(Request $request, $idSitioTuristico)
    {
        $sitioTuristico = SitioTuristico::find($idSitioTuristico);
        
        $idEmpresa = Auth::user()->id_empresa;
        $idUsuario = Auth::user()->id;

        $sitioTuristicoImagenes = [];

        if ($request->hasFile('file')) {
            foreach ($request->file ?? [] as $file) {                
                $sitioTuristicoImagen = new SitioTuristicoImagen();
    
                $extension = $file->extension();
                $nombreBase = Str::random(10) . "-" . time();
                $nombreImagen = $nombreBase . ".$extension";
    
                $path = $file->storeAs(
                    "empresas/$idEmpresa/sitios-turisticos/$idSitioTuristico/imagenes",
                    $nombreImagen,
                    'public'
                );
    
                $sitioTuristicoImagen->id_empresa = $idEmpresa;
                $sitioTuristicoImagen->id_usuario = $idUsuario;
                $sitioTuristicoImagen->id_sitio_turistico = $idSitioTuristico;
                $sitioTuristicoImagen->titulo = "";
                $sitioTuristicoImagen->descripcion = "";
                $sitioTuristicoImagen->leyenda = "";
                $sitioTuristicoImagen->texto_alternativo = "";
                $sitioTuristicoImagen->path = $path;
                $sitioTuristicoImagen->principal_tarjetas = 0;
                $sitioTuristicoImagen->principal_portadas = 0;
    
                $sitioTuristicoImagen->save();
    
                $sitioTuristicoImagenes[] = $sitioTuristicoImagen;
            }
        }

        if ((isset($request["json"]) && $request["json"] === false) || (isset($request["controller"]) && $request["controller"] === true)) {
            return $sitioTuristicoImagenes;
        }

        if (count($sitioTuristicoImagenes) === 0) {
            if ($request->has("session_flash")) {
                session()->flash('message', $request->input("session_flash"));
            }

            return response()->json([
                'code' => '400',
                'body' => [
                    'msg' => 'No se recibió ninguna imagen'
                ]
            ]);
        } else {
            if ($request->has("session_flash")) {
                session()->flash('message', "Imagenes guardadas exitosamente.");
            }

            return response()->json([
                'code' => '201',
                'body' => [
                    "modelos" => $sitioTuristicoImagenes,
                ]
            ]);
        }
    }

    public function update(Request $request, $idSitioTuristico, $idImagen)
    {
        $sitioTuristico = SitioTuristico::find($idSitioTuristico);
        $modeloImagen = SitioTuristicoImagen::find($idImagen);

        if ($request->isMethod("patch")) {
            $requestFiltrado = $request->except(["_method", "_token"]);
            
            foreach ($requestFiltrado as $nombreColumna => $valorColumna) {
                if ($nombreColumna === "principal_tarjetas") {
                    SitioTuristicoImagen::where('id_sitio_turistico', "=", $idSitioTuristico)
                        ->where('principal_tarjetas', "=", 1)
                        ->update(['principal_tarjetas' => 0]);
                } else if ($nombreColumna === "principal_portadas") {
                    SitioTuristicoImagen::where('id_sitio_turistico', "=", $idSitioTuristico)
                        ->where('principal_portadas', "=", 1)
                        ->update(['principal_portadas' => 0]);
                }

                $modeloImagen[$nombreColumna] = $valorColumna;
            }

            $modeloImagen->save();

            return response()->json([
                'code' => '200',
                'body' => [
                    "modelo" => $modeloImagen,
                ]
            ]);
        }
    }

    
    public function destroy(Request $request, $idSitioTuristico, $idImagen)
    {
        $sitioTuristico = SitioTuristico::find($idSitioTuristico);

        $modeloParaEliminar = SitioTuristicoImagen::find($idImagen);

        // Se elimina la imagen del almacenamiento del servidor
        Storage::disk("public")->delete($modeloParaEliminar->path);

        // Ahora se elimina el registro de la base de datos
        $modeloParaEliminar->delete();

        return response()->json([
            'code' => '200',
            'body' => [
                "deleted" => $modeloParaEliminar->toArray(),
            ]
        ]);
    }
}
