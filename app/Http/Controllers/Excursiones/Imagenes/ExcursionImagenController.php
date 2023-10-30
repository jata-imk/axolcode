<?php

namespace App\Http\Controllers\Excursiones\Imagenes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Excursiones\Excursion;
use App\Models\Excursiones\Imagenes\ExcursionesImagenes;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ExcursionImagenController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($idExcursion)
    {
        $excursionImagenes = ExcursionesImagenes::where('id_excursion', '=', $idExcursion)
        ->select()
        ->get();
        
        return response()->json([
            'code' => '200',
            'body' => [
                "imagenes" => $excursionImagenes,
            ]
        ]);
    }

    public function store(Request $request, $idExcursion)
    {
        $excursion = Excursion::find($idExcursion);

        if ($request->user()->cannot('update', $excursion)) {
            abort(403);
        }
        
        $idEmpresa = Auth::user()->id_empresa;
        $idUsuario = Auth::user()->id;

        $excursionesImagenes = [];

        if ($request->hasFile('file')) {
            foreach ($request->file ?? [] as $file) {                
                $excursionImagen = new ExcursionesImagenes;
    
                $extension = $file->extension();
                $nombreBase = Str::random(10) . "-" . time();
                $nombreImagen = $nombreBase . ".$extension";
    
                $path = $file->storeAs(
                    "empresas/$idEmpresa/excursiones/$idExcursion/imagenes",
                    $nombreImagen,
                    'public'
                );
    
                $excursionImagen->id_empresa = $idEmpresa;
                $excursionImagen->id_usuario = $idUsuario;
                $excursionImagen->id_excursion = $idExcursion;
                $excursionImagen->titulo = "";
                $excursionImagen->descripcion = "";
                $excursionImagen->leyenda = "";
                $excursionImagen->texto_alternativo = "";
                $excursionImagen->path = $path;
                $excursionImagen->principal_tarjetas = 0;
                $excursionImagen->principal_portadas = 0;
    
                $excursionImagen->save();
    
                $excursionesImagenes[] = $excursionImagen;
            }
        }

        if (count($excursionesImagenes) === 0) {
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
                session()->flash('message', $request->input("session_flash") . "Imagenes guardadas exitosamente.");
            }

            return response()->json([
                'code' => '201',
                'body' => [
                    "modelos" => $excursionesImagenes,
                ]
            ]);
        }
    }

    public function update(Request $request, $idExcursion, $idImagen)
    {
        $excursion = Excursion::find($idExcursion);

        if ($request->user()->cannot('update', $excursion)) {
            abort(403);
        }

        $modeloImagen = ExcursionesImagenes::find($idImagen);

        if ($request->isMethod("patch")) {
            $requestFiltrado = $request->except(["_method", "_token"]);
            
            foreach ($requestFiltrado as $nombreColumna => $valorColumna) {
                if ($nombreColumna === "principal") {
                    ExcursionesImagenes::where('id_excursion', "=", $idExcursion)
                        ->update(['principal' => 0]);
                } else if ($nombreColumna === "principal_portadas") {
                    ExcursionesImagenes::where('id_excursion', "=", $idExcursion)
                        ->update(['principal_portadas' => 0]);
                }

                $modeloImagen[$nombreColumna] = $valorColumna;
            }

            $modeloImagen->save();

            return response()->json([
                'code' => '200',
                'body' => [
                    "imagen" => $modeloImagen,
                    "modified" => $requestFiltrado
                ]
            ]);
        }
    }

    public function destroy(Request $request, $idExcursion, $idImagen)
    {
        $excursion = Excursion::find($idExcursion);

        // if ($request->user()->cannot('destroy', $excursion)) {
        //     abort(403);
        // }

        $modeloParaEliminar = ExcursionesImagenes::find($idImagen);
        
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
