<?php

namespace App\Http\Controllers\Clientes;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Clientes\Cliente;
use App\Models\Direcciones\Direccion;
use App\Models\Status\Status;

class ClienteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $this->authorize("viewAny", Cliente::class);

        if ($request->query("api")) {
            if ($request->query("api") == "true") {
                return $this->obtenerClientes($request);
            }
        }

        $clientes = Cliente::where('id_empresa', '=', Auth::user()->id_empresa)
            ->select('*')
            ->get();

        $cactivos = Cliente::where('id_status', '=', '1')
            ->where('id_empresa', '=', Auth::user()->id_empresa)
            ->count();
        $cinactivos = Cliente::where('id_status', '=', '0')
            ->where('id_empresa', '=', Auth::user()->id_empresa)
            ->count();

        $cclientes = Cliente::where('id_empresa', '=', Auth::user()->id_empresa)->select('*')->get()->count();

        $statusClientes = Status::where('id_empresa', '=', Auth::user()->id_empresa)
            ->select()
            ->get();

        return view('clientes.index', compact('clientes', 'cclientes', 'cactivos', 'cinactivos', 'statusClientes'));
    }

    // Mostrar formulario para agregar cliente
    public function create() {
        $this->authorize("create", Cliente::class);
        
        $statusClientes = Status::where("id_empresa", "=", Auth::user()->id_empresa)
            ->select()
            ->get();

        return view('clientes.agregar', compact(
            "statusClientes"
        ));
    }

    //Guardar en la base de datos
    public function store(Request $request) {
        $this->authorize("create", Cliente::class);
        
        $direccion["id_empresa"] = Auth::user()->id_empresa;
        $direccion["id_usuario"] = Auth::user()->id;
        $direccion["linea1"] = $request->linea1;
        $direccion["linea3"] = $request->linea3;
        $direccion["codigo_postal"] = $request->codigo_postal;
        $direccion["codigo_pais"] = $request->pais;
        $direccion["estado"] = $request->estado;
        $direccion["ciudad"] = $request->ciudad;

        $res_direccion = Direccion::create($direccion);

        $formCliente = $request->all();

        $formCliente["id_empresa"] = Auth::user()->id_empresa;
        $formCliente["id_usuario_alta"] = Auth::user()->id;
        $formCliente["id_ejecutivo"] = 0;

        $formCliente["fecha_alta"] = date("Y-m-d");

        $formCliente["id_status"] = $request->id_status;
        $formCliente["id_direccion"] = $res_direccion->id;

        $formCliente["telefono_celular"] = $request->telefono_celular ?? "";
        $formCliente["telefono_casa"] = $request->telefono_casa ?? "";
        $formCliente["email_secundario"] = $request->email_secundario ?? "";

        Cliente::create($formCliente);

        return redirect()->route('clientes.index')->with('message', 'Usuario agregado correctamente');
    }

    //Mostrar formulario para editar
    public function edit(Cliente $cliente) {
        $this->authorize("view", $cliente);

        $direccion = Direccion::where('id', '=', $cliente->id_direccion)
            ->select('*')
            ->get();

        $statusClientes = Status::where('id_empresa', '=', Auth::user()->id_empresa)
            ->select()
            ->get();

        return view('clientes.editar', compact('cliente', 'direccion', 'statusClientes'));
    }

    //Guardar cambios de un cliente
    public function update(Request $request, Cliente $cliente) {
        $this->authorize("update", $cliente);

        $cliente->update(
            array_merge(
                $request->all(),
                [
                    "telefono_casa" => $request->telefono_casa ?? "",
                    "email_secundario" => $request->email_secundario ?? ""
                ]
            )
        );

        $direccion = Direccion::find($cliente->id_direccion);
        $direccion->update($request->all());

        return redirect()->route('clientes.index');
    }

    public function destroy(Request $request, Cliente $cliente) {
        $this->authorize("delete", $cliente);

        $id_direccion = $cliente->id_direccion;
        $cliente->delete();

        $direccion = Direccion::find($id_direccion);
        $direccion->delete();

        return response()->json([
            'code' => '200',
            'body' => [
                "msg" => "",
            ]
        ], 200);
    }

    public function obtenerClientes(Request $request)
    {
        $clientes = null;

        if ($request->query("q")) {
            $clientes = Cliente::where(DB::raw('CONCAT_WS(" ", nombre, apellido, telefono_celular_codigo_pais, telefono_celular, telefono_casa_codigo_pais, telefono_casa, email_principal, email_secundario)'), "like", "%" . $request->query("q") . "%")
                                ->where('id_empresa', '=', Auth::user()->id_empresa)            
                                ->select("clientes.*", DB::raw('CONCAT_WS(" ", nombre, apellido) AS nombre_completo'))
                                ->get();
        } else {
            $clientes = Cliente::where('id_empresa', '=', Auth::user()->id_empresa)
                                ->select()
                                ->get();
        }

        return response()->json([
            'code' => '200',
            'body' => [
                "clientes" => $clientes
            ]
        ], 200);
    }
}

