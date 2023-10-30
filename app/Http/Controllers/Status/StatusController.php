<?php

namespace App\Http\Controllers\Status;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Status\Status;

class StatusController extends Controller
{
    public function index()
    {
        $status = Status::where('id_empresa', '=', Auth::user()->id_empresa)
            ->select('*')
            ->get();

        $cstatus = Status::where('id_empresa', '=', Auth::user()->id_empresa)
            ->select('*')
            ->get()
            ->count();

        return view('status.index', compact('status', 'cstatus'));
    }

    public function create()
    {
        return view('status.agregar');
    }

    public function store(Request $request)
    {
        $form = $request->all();

        $form["id_empresa"] = Auth::user()->id_empresa;
        $form["id_usuario"] = Auth::user()->id;

        Status::create($form);

        return redirect()->route('status.index')->with('message', 'Status agregado correctamente');
    }

    public function edit(Status $status)
    {
        return view('status.editar', compact('status'));
    }

    //Guardar cambios
    public function update(Request $request, Status $status)
    {
        $status->update($request->all());
        
        return redirect()->route('status.index')->with('message', 'Status editado correctamente');
    }

    public function destroy(Request $request, Status $status)
    {
        $idstatus = $status->id;
        $status->delete();
        //Falta validar si el tipo de tour es usado, si es usado no debe permitirse eliminar
    }
}
