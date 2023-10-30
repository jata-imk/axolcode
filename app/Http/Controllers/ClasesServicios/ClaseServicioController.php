<?php

namespace App\Http\Controllers\ClasesServicios;

use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\ClasesServicios\ClaseServicio;

class ClaseServicioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clasesServicios = ClaseServicio::where('id_empresa', '=', Auth::user()->id_empresa)
            ->select()
            ->get();

        return view('clases-servicios.index', compact(
            'clasesServicios'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('clases-servicios.agregar');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        ClaseServicio::create(array_merge(
            $request->all(),
            [
                "id_empresa" => Auth::user()->id_empresa,
                "id_usuario" => Auth::user()->id,
            ]
        ));

        return redirect()->route('clases-servicios.index')->with('message', 'Clase con nombre: ' . $request->input("nombre") . ', agregada correctamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $claseServicio = ClaseServicio::find($id);

        return view('clases-servicios.editar', compact(
            'claseServicio'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $claseServicio = ClaseServicio::find($id);

        $claseServicio->update($request->all());

        return redirect()->route('clases-servicios.index')->with('message', 'Clase con nombre: ' . $request->input("nombre") . ', actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $claseServicio = ClaseServicio::find($id);

        $claseServicio->delete();
    }
}
