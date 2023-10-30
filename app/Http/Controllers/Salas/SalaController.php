<?php

namespace App\Http\Controllers\Salas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Direcciones\Direccion;
use App\Models\Salas\Sala;

class SalaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $this->authorize("viewAny", Sala::class);

        $salas = Sala::leftJoin("direcciones", "salas.id_direccion", "=", "direcciones.id")
            ->where('salas.id_empresa', '=', Auth::user()->id_empresa)
            ->select([
                'salas.*',
                'direcciones.linea1',
                'direcciones.linea2',
                'direcciones.linea3',
                'direcciones.codigo_postal',
                'direcciones.ciudad',
                'direcciones.estado',
                'direcciones.codigo_pais',
            ])
            ->get();

        $csalas = Sala::where('id_empresa', '=', Auth::user()->id_empresa)
            ->select()
            ->get()
            ->count();

        return view('salas.index', compact(
            'salas',
            'csalas'
        ));
    }

    public function edit(Sala $sala)
    {
        $this->authorize("view", $sala);

        $direccion = Direccion::where('id', '=', $sala->id_direccion)
            ->select()
            ->get();

        return view('salas.editar', compact(
            'sala',
            'direccion'
        ));
    }

    public function update(Request $request, Sala $sala)
    {
        $this->authorize("update", $sala);

        $form = $request->all();

        if($request->idDireccion == 0){
            $formdireccion["id_empresa"] = Auth::user()->id_empresa;
            $formdireccion["id_usuario"] = Auth::user()->id;
            $formdireccion["linea1"] = $request->linea1;
            $formdireccion["linea3"] = $request->linea3;
            $formdireccion["codigo_postal"] = $request->codigo_postal;
            $formdireccion["ciudad"] = $request->ciudad;
            $formdireccion["estado"] = $request->estado;
            $formdireccion["codigo_pais"] = $request->codigo_pais;

            $iddireccion = Direccion::create($formdireccion);
            $form["id_direccion"] = $iddireccion->id;
        } else {
            $direccion = Direccion::find($request->idDireccion);
            $form["id_direccion"] = $request->idDireccion;
            $direccion->update($form);
        }

        $sala->update($form);

        return redirect()->route('salas.index')->with('message', 'Sala editada exitosamente');
    }

    public function create() {
        $this->authorize("create", Sala::class);

        return view('salas.agregar');
    }

    public function store(Request $request)
    {
        $this->authorize("create", Sala::class);

        $formdireccion["id_empresa"] = Auth::user()->id_empresa;
        $formdireccion["id_usuario"] = Auth::user()->id;
        $formdireccion["linea1"] = $request->linea1;
        $formdireccion["linea3"] = $request->linea3;
        $formdireccion["codigo_postal"] = $request->codigo_postal;
        $formdireccion["ciudad"] = $request->ciudad;
        $formdireccion["estado"] = $request->estado;
        $formdireccion["codigo_pais"] = $request->codigo_pais;
        $direccion = Direccion::create($formdireccion);

        $formsala["id_empresa"] = Auth::user()->id_empresa;
        $formsala["id_usuario"] = Auth::user()->id;
        $formsala["nombre"] = $request->nombre;
        $formsala["id_direccion"] = $direccion->id;
        Sala::create($formsala);

        return redirect()->route('salas.index')->with('message', "Sala creada exitosamente");
    }

    public function destroy(Request $request, Sala $sala)
    {
        $this->authorize("delete", $sala);

        $sala->delete();

        return response()->json([
            'code' => '200',
            'body' => [
                "msg" => "",
            ]
        ], 200);
    }
}
