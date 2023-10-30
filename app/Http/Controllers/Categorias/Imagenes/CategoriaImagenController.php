<?php

namespace App\Http\Controllers\Categorias\Imagenes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Categorias\Categoria;
use App\Models\Categorias\Imagenes\CategoriaImagen;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CategoriaImagenController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($idCategoria)
    {
        $categoriaImagenes = CategoriaImagen::where('id_categoria', '=', $idCategoria)
            ->select()
            ->get();
        
        return response()->json([
            'code' => '200',
            'body' => [
                "imagenes" => $categoriaImagenes,
            ]
        ]);
    }

    public static function store(Request $request, $idCategoria)
    {
        $categoria = Categoria::find($idCategoria);
        
        $idEmpresa = Auth::user()->id_empresa;
        $idUsuario = Auth::user()->id;

        $categoriaImagenes = [];

        if ($request->hasFile('file')) {
            foreach ($request->file ?? [] as $file) {                
                $categoriaImagen = new CategoriaImagen();
    
                $extension = $file->extension();
                $nombreBase = Str::random(10) . "-" . time();
                $nombreImagen = $nombreBase . ".$extension";
    
                $path = $file->storeAs(
                    "empresas/$idEmpresa/categorias/$idCategoria/imagenes",
                    $nombreImagen,
                    'public'
                );
    
                $categoriaImagen->id_empresa = $idEmpresa;
                $categoriaImagen->id_usuario = $idUsuario;
                $categoriaImagen->id_categoria = $idCategoria;
                $categoriaImagen->titulo = "";
                $categoriaImagen->descripcion = "";
                $categoriaImagen->leyenda = "";
                $categoriaImagen->texto_alternativo = "";
                $categoriaImagen->path = $path;
                $categoriaImagen->principal_tarjetas = 0;
                $categoriaImagen->principal_portadas = 0;
    
                $categoriaImagen->save();
    
                $categoriaImagenes[] = $categoriaImagen;
            }
        }

        if ((isset($request["json"]) && $request["json"] === false) || (isset($request["controller"]) && $request["controller"] === true)) {
            return $categoriaImagenes;
        }

        if (count($categoriaImagenes) === 0) {
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
                    "modelos" => $categoriaImagenes,
                ]
            ]);
        }
    }

    public function update(Request $request, $idCategoria, $idImagen)
    {
        $categoria = Categoria::find($idCategoria);
        $modeloImagen = CategoriaImagen::find($idImagen);

        if ($request->isMethod("patch")) {
            $requestFiltrado = $request->except(["_method", "_token"]);
            
            foreach ($requestFiltrado as $nombreColumna => $valorColumna) {
                if ($nombreColumna === "principal_tarjetas") {
                    CategoriaImagen::where('id_categoria', "=", $idCategoria)
                        ->where('principal_tarjetas', "=", 1)
                        ->update(['principal_tarjetas' => 0]);
                } else if ($nombreColumna === "principal_portadas") {
                    CategoriaImagen::where('id_categoria', "=", $idCategoria)
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

    
    public function destroy(Request $request, $idCategoria, $idImagen)
    {
        $categoria = Categoria::find($idCategoria);

        $modeloParaEliminar = CategoriaImagen::find($idImagen);

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
