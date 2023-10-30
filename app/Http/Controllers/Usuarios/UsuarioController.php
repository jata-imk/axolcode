<?php

namespace App\Http\Controllers\Usuarios;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Usuario;
use App\Models\Empresas\Empresa;

class UsuarioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $this->authorize("viewAny", Usuario::class);

        $usuarios = null;

        if (Auth::user()->id_rol === 0) {
            $usuarios = Usuario::leftJoin("roles", "usuarios.id_rol", "=", "roles.id")
                ->leftJoin("empresas", "usuarios.id_empresa", "=", "empresas.id")
                ->select(["usuarios.*", "roles.nombre as rol_nombre", "empresas.nombre_comercial as empresa_nombre_comercial"])
                ->get();
        } else {
            $usuarios = Usuario::leftJoin("roles", "usuarios.id_rol", "=", "roles.id")
                ->where("usuarios.id_empresa", "=", Auth::user()->id_empresa)
                ->select(["usuarios.*", "roles.nombre as rol_nombre"])
                ->get();
        }
        
        return view('usuarios.index', [
            "usuarios" => $usuarios
        ]);
    }

    public function edit($idUsuario) {
        $usuario = Usuario::find($idUsuario);        
        $this->authorize("view", $usuario);

        $empresas = Empresa::all(["id", "nombre_comercial", "razon_social"]);

        $rolesEmpresa = Empresa::leftJoin("roles", "empresas.id", "=", "roles.id_empresa")
                ->where("roles.id_empresa", "=", $usuario->id_empresa)
                ->select(["roles.id", "roles.nombre"])
                ->get();

        return view('usuarios.editar', [
            "empresas" => $empresas,
            "usuario" => $usuario,
            "rolesEmpresa" => $rolesEmpresa
        ]);
    }

    public function update(Request $request, $idUsuario)
    {
        $usuario = Usuario::find($idUsuario);

        $this->authorize("update", $usuario);

        $usuario->id_empresa = ($request->has("id_empresa")) ? $request->input("id_empresa") : Auth::user()->id_empresa;
        $usuario->usuario_nombre = $request->input("usuario_nombre");
        $usuario->usuario_apellido = $request->input("usuario_apellido");
        $usuario->name = $request->input("usuario_nombre") . " " . $request->input("usuario_apellido");
        $usuario->telefono_celular = $request->input("telefono_celular") ?? "";
        $usuario->telefono_celular_codigo_pais = $request->input("telefono_celular_codigo_pais") ?? "";
        $usuario->email = $request->input("email");

        if ($request->input("password") !== NULL) {
            $usuario->password = Hash::make($request->input("password"));    
        }

        $usuario->id_rol = $request->input("id_rol");

        $usuario->save();

        return redirect()->route('usuarios.index');
    }

    public function create() {
        $this->authorize("create", Usuario::class);

        $empresas = Empresa::all(["id", "nombre_comercial", "razon_social"]);

        $rolesEmpresa = Empresa::leftJoin("roles", "empresas.id", "=", "roles.id_empresa")
            ->where("roles.id_empresa", "=", Auth::user()->id_empresa)
            ->select(["roles.id", "roles.nombre"])
            ->get();

        return view('usuarios.agregar', [
            "empresas" => $empresas,
            "rolesEmpresa" => $rolesEmpresa
        ]);
    }

    public function store(Request $request) {
        $this->authorize("create", Usuario::class);
        
        $usuario = new Usuario;

        $usuario->id_empresa = ($request->has("id_empresa")) ? $request->input("id_empresa") : Auth::user()->id_empresa;
        $usuario->usuario_nombre = $request->input("usuario_nombre");
        $usuario->usuario_apellido = $request->input("usuario_apellido");
        $usuario->name = $request->input("usuario_nombre") . " " . $request->input("usuario_apellido");
        $usuario->telefono_celular = $request->input("telefono_celular") ?? "";
        $usuario->telefono_celular_codigo_pais = $request->input("telefono_celular_codigo_pais") ?? "";
        $usuario->email = $request->input("email");
        $usuario->password = Hash::make($request->input("password"));
        $usuario->id_rol = $request->input("id_rol");

        $usuario->save();

        return redirect()->route('usuarios.index');
    }
}
