<?php

namespace App\Http\Controllers\Afiliados;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\Afiliados\Afiliado;
use App\Models\Empresas\Empresa;
use App\Models\NivelesAfiliacion\NivelAfiliacion;
use App\Models\PaginasWeb\PaginaWeb;

class AfiliadoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {

        //$this->authorize("viewAny", Afiliado::class);

        if ($request->query("api")) {
            if ($request->query("api") == "true") {
                return $this->obtenerAfiliado($request);
            }
        }

        $laempresa = Empresa::find(Auth::user()->id_empresa);
        $afiliados = Afiliado::where('id_empresa', '=', Auth::user()->id_empresa)->select('*')->get();

        $activos = Afiliado::where('id_empresa', '=', Auth::user()->id_empresa)
        ->where('estatus', '=', '1')
        ->select('*')->get()->count();

        $inactivos = Afiliado::where('id_empresa', '=', Auth::user()->id_empresa)
        ->where('estatus', '=', '0')
        ->select('*')->get()->count();

        return view('afiliados.index', compact('afiliados', 'laempresa', 'activos', 'inactivos'));
    }

    public function create(){
        $niveles = NivelAfiliacion::where('id_empresa', '=', Auth::user()->id_empresa)->select('*')->get();
        return view('afiliados.agregar', compact('niveles'));
    }

    public function store(Request $request){
        $form = $request->all();
        $form["id_empresa"] = Auth::user()->id_empresa;
        $form["id_usuario"] = Auth::user()->id;
        $form["fecha_alta"] = '2022-10-10';
        $form["link_afiliado"] = $this->generateRandomString(10);

        Afiliado::create($form);
        return redirect()->route('afiliados.index')->with('message', 'Afiliado guarado exitósamente');
    }

    public function show(){

    }

    public function edit(Afiliado $afiliado){
        $web = PaginaWeb::
        where('id_empresa', '=', Auth::user()->id_empresa)
        ->select('pagina_web')
        ->get();
        $niveles = NivelAfiliacion::where('id_empresa', '=', Auth::user()->id_empresa)->select('*')->get();

        return view('afiliados.editar', compact('afiliado', 'niveles', 'web'));
    }

    public function update(Request $request, Afiliado $afiliado){
        $afiliado->update($request->all());
        return redirect()->route('afiliados.index')->with('message', 'Afiliado actualizado con éxito');
    }

    public function destroy(Request $request, Afiliado $afiliado){
        $form["estatus"] = 0;
        $afiliado->update($form);
        //$afiliado->delete();
    }

    public function nivelafiliados(){
        return view('afiliados.index');
    }

    public function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }

    public function obtenerAfiliado(Request $request)
    {
        $afiliados = null;

        if ($request->query("q")) {
            $afiliados = Afiliado::where(DB::raw('CONCAT_WS(" ", nombre_comercial, razon_social, rfc, telefono_celular_codigo_pais, telefono_celular, telefono_oficina_codigo_pais, telefono_oficina)'), "like", "%" . $request->query("q") . "%")
                            ->select()
                            ->get();
        }

        return response()->json([
            'code' => '200',
            'body' => [
                "afiliados" => $afiliados
            ]
        ], 200);
    }
}
