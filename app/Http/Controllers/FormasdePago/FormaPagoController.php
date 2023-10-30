<?php

namespace App\Http\Controllers\FormasdePago;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\FormasPago\FormaPago;

class FormaPagoController extends Controller
{
    public function index()
    {
        $formasdepago = FormaPago::select('*')->get();
        $cformasdepago = FormaPago::select('*')->get()->count();
        return view('formaspago.index', compact('formasdepago', 'cformasdepago'));
    }

    public function edit($id)
    {
        $formadepago = FormaPago::find($id);
        return view('formaspago.editar', compact('formadepago'));
    }

    public function create()
    {
        return view('formaspago.agregar');
    }

    public function store(Request $request)
    {
        $form = $request->all();
        FormaPago::create($form);
        return redirect()->route('formaspago.index')->with('message', 'Forma de pago agregada correctamente');
    }

    public function update(Request $request)
    {
        $idforma = $request->idforma;
        $formadepago = FormaPago::find($idforma);
        $formadepago->nombre = $request->input('nombre');
        $formadepago->descripcion = $request->input('descripcion');
        $formadepago->save();
        return redirect()->route('formaspago.index')->with('message', 'Forma de pago editada correctamente');
    }

    public function destroy(Request $request, $id)
    {
        $idforma = FormaPago::find($id);
        $idforma->delete();
    }
}
