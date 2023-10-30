<?php

namespace App\Http\Controllers\Empresas;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Empresas\Empresa;
use App\Models\PaginasWeb\PaginaWeb;
use App\Models\Direcciones\Direccion;
use App\Models\Roles\Rol;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class EmpresaController extends Controller
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
    public function index()
    {
        $this->authorize("viewAny", Empresa::class);

        $empresas = DB::select("SELECT * FROM empresas");
        $empresasActivas = DB::select("SELECT * FROM empresas WHERE id_empresa_status = ?", [2]);

        return view('empresas.index', [
            "empresas" => $empresas,
            "empresasActivas" => $empresasActivas
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($idEmpresa)
    {
        $empresa = Empresa::find($idEmpresa);

        $this->authorize("view", $empresa);

        $direccionComercial = Direccion::where("id", "=", $empresa->id_direccion_comercial)
            ->select("*")
            ->get();

        $direccionFiscal = Direccion::where("id", "=", $empresa->id_direccion_fiscal)
            ->select("*")
            ->get();

        return view('empresas.editar', [
            "empresa" => $empresa,
            "direccionComercial" => $direccionComercial,
            "direccionFiscal" => $direccionFiscal,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $idEmpresa)
    {
        $empresa = Empresa::find($idEmpresa);
        $this->authorize("update", $empresa);

        if ($request->isMethod("patch")) {
            $requestFiltrado = $request->except(["_method", "_token"]);

            foreach ($requestFiltrado as $nombreColumna => $valorColumna) {
                $empresa[$nombreColumna] = $valorColumna;
            }

            $empresa->save();

            return response()->json([
                'code' => '200',
                'body' => [
                    "id_empresa" => $idEmpresa,
                    "modified" => $requestFiltrado
                ]
            ]);
        } else {
            $empresa->nombre_comercial = $request->input("empresa-nombre-comercial");
            $empresa->razon_social = $request->input("empresa-razon-social");
            $empresa->telefono_oficina = $request->input("empresa-telefono-oficina");
            $empresa->telefono_oficina_codigo_pais = $request->input("empresa-telefono-oficina-codigo-pais");
            $empresa->telefono_celular = $request->input("empresa-telefono-celular");
            $empresa->telefono_celular_codigo_pais = $request->input("empresa-telefono-celular-codigo-pais");
            $empresa->rfc = $request->input("empresa-rfc");
            $empresa->id_tipo_persona = $request->input("empresa-tipo-persona");
            $empresa->id_tipo_empresa = $request->input("empresa-tipo-empresa");

            $empresa->save();

            $direccionComercial = Direccion::find($empresa->id_direccion_comercial);

            $direccionComercial->linea1 = $request->input("direccion-comercial-linea-uno");
            $direccionComercial->linea2 = $request->input("direccion-comercial-linea-dos") ?? "";
            $direccionComercial->linea3 = $request->input("direccion-comercial-linea-tres") ?? "";
            $direccionComercial->codigo_postal = $request->input("direccion-comercial-cp");
            $direccionComercial->ciudad = $request->input("direccion-comercial-ciudad") ?? "";
            $direccionComercial->estado = $request->input("direccion-comercial-estado") ?? "";
            $direccionComercial->codigo_pais = $request->input("direccion-comercial-pais") ?? "";

            $direccionComercial->save();

            $direccionFiscal = Direccion::find($empresa->id_direccion_fiscal);

            $direccionFiscal->linea1 = $request->input("direccion-fiscal-linea-uno");
            $direccionFiscal->linea2 = $request->input("direccion-fiscal-linea-dos") ?? "";
            $direccionFiscal->linea3 = $request->input("direccion-fiscal-linea-tres") ?? "";
            $direccionFiscal->codigo_postal = $request->input("direccion-fiscal-cp");
            $direccionFiscal->ciudad = $request->input("direccion-fiscal-ciudad") ?? "";
            $direccionFiscal->estado = $request->input("direccion-fiscal-estado") ?? "";
            $direccionFiscal->codigo_pais = $request->input("direccion-fiscal-pais") ?? "";

            $direccionFiscal->save();

            return redirect()->route('empresas.index');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize("create", Empresa::class);

        return view('empresas.agregar');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize("create", Empresa::class);

        $idUsuario = Auth::user()->id;
        $idEmpresa = DB::table('empresas')->insertGetId([
            'nombre_comercial' => $request->input("empresa-nombre-comercial"),
            'razon_social' => $request->input("empresa-razon-social"),
            'telefono_oficina' => $request->input("empresa-telefono-oficina"),
            'telefono_oficina_codigo_pais' => $request->input("empresa-telefono-oficina-codigo-pais"),
            'telefono_celular' => $request->input("empresa-telefono-celular"),
            'telefono_celular_codigo_pais' => $request->input("empresa-telefono-celular-codigo-pais"),
            'rfc' => $request->input("empresa-rfc"),
            'id_tipo_persona' => $request->input("empresa-tipo-persona"),
            'id_tipo_empresa' => $request->input("empresa-tipo-empresa"),
            'fecha_alta' => DB::raw("CURDATE()"),
            'fecha_vencimiento' => "0001-01-01",
            'fecha_ultimo_pago' => "0001-01-01",
            'id_empresa_status' => 2,
            'public_key' => Str::random(20),
            'private_key' => Str::random(35),
            'created_at' => DB::raw("CURRENT_TIMESTAMP"),
            'updated_at' => DB::raw("CURRENT_TIMESTAMP"),
        ]);

        $idDireccionComercial = DB::table('direcciones')->insertGetId([
            'id_empresa' => $idEmpresa,
            'id_usuario' => $idUsuario,
            'linea1' => $request->input("direccion-comercial-linea-uno"),
            'linea2' => $request->input("direccion-comercial-linea-dos") ?? "", //Opcional
            'linea3' => $request->input("direccion-comercial-linea-tres") ?? "", //Opcional
            'codigo_postal' => $request->input("direccion-comercial-cp"),
            'ciudad' => $request->input("direccion-comercial-ciudad") ?? "",
            'estado' => $request->input("direccion-comercial-estado") ?? "",
            'codigo_pais' => $request->input("direccion-comercial-pais") ?? "",
            'created_at' => DB::raw("CURRENT_TIMESTAMP"),
            'updated_at' => DB::raw("CURRENT_TIMESTAMP"),
        ]);

        $idDireccionFiscal = 0;

        if ($request->has("direccion-fiscal-misma-que-comercial")) {
            $idDireccionFiscal = DB::table('direcciones')->insertGetId([
                'id_empresa' => $idEmpresa,
                'id_usuario' => $idUsuario,
                'linea1' => $request->input("direccion-comercial-linea-uno"),
                'linea2' => $request->input("direccion-comercial-linea-dos") ?? "", //Opcional
                'linea3' => $request->input("direccion-comercial-linea-tres") ?? "", //Opcional
                'codigo_postal' => $request->input("direccion-comercial-cp"),
                'ciudad' => $request->input("direccion-comercial-ciudad") ?? "",
                'estado' => $request->input("direccion-comercial-estado") ?? "",
                'codigo_pais' => $request->input("direccion-comercial-pais") ?? "",
                'created_at' => DB::raw("CURRENT_TIMESTAMP"),
                'updated_at' => DB::raw("CURRENT_TIMESTAMP"),
            ]);
        } else {
            $idDireccionFiscal = DB::table('direcciones')->insertGetId([
                'id_empresa' => $idEmpresa,
                'id_usuario' => $idUsuario,
                'linea1' => $request->input("direccion-fiscal-linea-uno"),
                'linea2' => $request->input("direccion-fiscal-linea-dos") ?? "", //Opcional
                'linea3' => $request->input("direccion-fiscal-linea-tres") ?? "", //Opcional
                'codigo_postal' => $request->input("direccion-fiscal-cp"),
                'ciudad' => $request->input("direccion-fiscal-ciudad") ?? "",
                'estado' => $request->input("direccion-fiscal-estado") ?? "",
                'codigo_pais' => $request->input("direccion-fiscal-pais") ?? "",
                'created_at' => DB::raw("CURRENT_TIMESTAMP"),
                'updated_at' => DB::raw("CURRENT_TIMESTAMP"),
            ]);
        }

        DB::table("empresas")->where("id", "=", $idEmpresa)->update([
            "id_direccion_comercial" => $idDireccionComercial,
            "id_direccion_fiscal" => $idDireccionFiscal,
        ]);

        // Se crea un rol asociado a la empresa (Administrador)
        $rolAdministradorEmpresa = new Rol;
        $rolAdministradorEmpresa->id_empresa = $idEmpresa;
        $rolAdministradorEmpresa->id_usuario = $idUsuario;
        $rolAdministradorEmpresa->nombre = "Administrador";
        $rolAdministradorEmpresa->save();

        //Crear un registro para su pagina web
        $paginaWeb = new PaginaWeb;

        if ($request->hasFile('pagina-web-logo')) {
            $extension = $request->file('pagina-web-logo')->extension();
            $nombreBase = $idEmpresa . "-logo-web-" . time();
            $nombreImagen = $nombreBase . ".{$extension}";

            $path = $request->file('pagina-web-logo')->storeAs(
                "empresas/$idEmpresa/pagina-web/logo",
                $nombreImagen,
                'public'
            );

            $paginaWeb->id_empresa = $idEmpresa;
            $paginaWeb->id_usuario = $idUsuario;
            $paginaWeb->pagina_web = $request->input("pagina-web-url");
            $paginaWeb->logo_web = $path;

            $paginaWeb->footer_copyright = "";
            $paginaWeb->politicas = "";
            $paginaWeb->aviso_privacidad = "";

            $paginaWeb->save();
        }

        return redirect()->route('empresas.index');
    }

    public function obtenerRolesEmpresa($idEmpresa)
    {
        $rolesEmpresa = Empresa::leftJoin("roles", "empresas.id", "=", "roles.id_empresa")
            ->where("roles.id_empresa", "=", $idEmpresa)
            ->select(["roles.id", "roles.nombre"])
            ->get();

        return response()->json($rolesEmpresa);
    }
}
