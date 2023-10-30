<?php

namespace App\Http\Controllers\Distintivos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Distintivos\Distintivo;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class DistintivoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $distintivos = Distintivo::where('id_empresa', '=', Auth::user()->id_empresa)
            ->select()
            ->get();

        $cdistintivos = Distintivo::where('id_empresa', '=', Auth::user()->id_empresa)
            ->select()
            ->get()
            ->count();

        return view('distintivos.index', compact(
            'distintivos',
            'cdistintivos'
        ));
    }

    public function edit(Distintivo $distintivo)
    {
        return view('distintivos.editar', compact(
            'distintivo'
        ));
    }

    public function update(Request $request, Distintivo $distintivo)
    {
        $idEmpresa = Auth::user()->id_empresa;
        $formDistintivo = $request->all();

        if ($request->hasFile('logo')) {
            $extension = $request->file('logo')->extension();
            $nombreBase = Str::random(10) . "-" . time();
            $nombreImagen = $nombreBase . ".{$extension}";

            $path = $request->file('logo')->storeAs(
                "empresas/$idEmpresa/pagina-web/distintivos",
                $nombreImagen,
                'public'
            );

            // Se elimina la imagen anterior
            Storage::disk("public")->delete($distintivo->logo);

            $formDistintivo["logo"] = $path;
            $mensaje="Distintivo editado correctamente. Se actualizó el logotipo del distintivo";
        } else {
            $mensaje="Distintivo editado correctamente.";
        }

        $distintivo->update($formDistintivo);

        return redirect()->route('distintivos.index')->with('message', $mensaje);
    }

    public function create(){
        return view('distintivos.agregar');
    }

    public function store(Request $request)
    {
        $formDistintivo = $request->all();
        $formDistintivo["id_empresa"]      = Auth::user()->id_empresa;
        $formDistintivo["id_usuario"]      = Auth::user()->id;
        if ($request->hasFile('logo')) {
            $file    = $request->file("logo");
            $nombre  = "img_".time().".".$file->guessExtension();
            $ruta    = public_path("distintivos/".Auth::user()->id_empresa."/".$nombre);
            $carpeta = public_path("distintivos/".Auth::user()->id_empresa."/");

            if(!is_dir($carpeta)){
                @mkdir($carpeta, 0700);
            }

            copy($file, $ruta);
            $formDistintivo["logo"] = Auth::user()->id_empresa."/".$nombre;
            $mensaje="Distintivo agregado correctamente. Se subió el logotipo del distintivo";
        }else{
            $mensaje="Distintivo agregado correctamente.";
        }
        Distintivo::create($formDistintivo);
        return redirect()->route('distintivos.index')->with('message', $mensaje);
    }

    public function destroy(Request $request, Distintivo $distintivo){
        $distintivo->delete();
    }
}
