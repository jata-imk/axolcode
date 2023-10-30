<?php

namespace App\Http\Controllers\MiPerfil;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Models\Perfiles\Perfil;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class MiPerfilController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $misDatos = Perfil::where('usuarios.id', '=', Auth::user()->id)
            ->leftJoin('roles', 'roles.id', '=', 'usuarios.id_rol')
            ->leftJoin('empresas', 'empresas.id', '=', 'usuarios.id_empresa')
            ->select('usuarios.*', 'roles.nombre as nombreRol', 'empresas.nombre_comercial')
            ->first();

        $this->authorize("view", $misDatos);

        return view('mi_perfil.index', compact(
            'misDatos'
        ));
    }

    public function update(Request $request, $idPerfil)
    {
        $miPerfil = Perfil::find($idPerfil);

        $this->authorize("update", $miPerfil);

        if ($request->isMethod("patch")) {
            if ($request->has("imagen_perfil")) {
                //Borramos la antigua foto
                if ($miPerfil->imagen_perfil != "") {
                    Storage::disk("public")->delete($miPerfil->imagen_perfil);
                }
    
                $extension = $request->file("imagen_perfil")->extension();
                $nombreBase = Str::random(10) . "-" . time();
                $nombreImagen = $nombreBase . ".$extension";

                $idEmpresa = Auth::user()->id_empresa;
    
                $path = $request->file("imagen_perfil")->storeAs(
                    "empresas/$idEmpresa/usuarios/$miPerfil->id/imagenes",
                    $nombreImagen,
                    'public'
                );
        
                $miPerfil->imagen_perfil = $path;
                $miPerfil->save();

                return response()->json([
                    'code' => '200',
                    'body' => [
                        "id" => $miPerfil->id,
                        "imagen_perfil" => $path
                    ]
                ], 200);
            }
        } else {
            $form["name"] = $request->usuario_nombre." ".$request->usuario_apellido;
            $form["usuario_nombre"] = $request->usuario_nombre;
            $form["usuario_apellido"] = $request->usuario_apellido;
            $form["telefono_celular"] = $request->telefono_celular ?? "";
            $form["telefono_celular_codigo_pais"] = $request->telefono_celular_codigo_pais ?? "";
            $form["email"] = $request->email;
    
    
            if($request->password !== null) {
                $form["password"] = Hash::make($request->password);
            }
    
            $miPerfil->update($form);
    
            return redirect()->route('mi_perfil.index')->with('message', 'Los datos se han actualizados exitosamente');
        }
    }
}
