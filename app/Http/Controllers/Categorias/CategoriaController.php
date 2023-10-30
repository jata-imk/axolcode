<?php

namespace App\Http\Controllers\Categorias;

use App\Http\Controllers\Categorias\Imagenes\CategoriaImagenController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Categorias\Categoria;

class CategoriaController extends Controller
{
    public function index()
    {
        $categorias = Categoria::where('id_empresa', '=', Auth::user()->id_empresa)
            ->select()
            ->get();

        return view('categorias.index', compact('categorias'));
    }

    public function create()
    {
        return view('categorias.agregar');
    }

    public function store(Request $request)
    {
        $form = $request->all();

        $form["id_empresa"] = Auth::user()->id_empresa;
        $form["id_usuario"] = Auth::user()->id;
        
        $categoria = Categoria::create($form);

        if ($request->hasFile('file')) {
            $request->merge([
                "controller" => true,
            ]);

            $categoriasImagenes = CategoriaImagenController::store($request, $categoria->id);
        }

        if (($request->query("api")) && ($request->query("api") == true)) {
            $categoria->imagenes;

            return response()->json([
                'code' => '201',
                'body' => [
                    "categoria" => $categoria,
                ]
            ]);
        } else {
            return redirect()->route('categorias.index')->with('message', 'Categoría agregado correctamente');
        }
    }

    public function edit(Categoria $categoria)
    {
        return view('categorias.editar', compact('categoria'));
    }

    public function update(Request $request, Categoria $categoria)
    {
        $categoria->update($request->all());

        return redirect()->route('categorias.index')->with('message', 'Categoría editada correctamente');
    }

    public function destroy(Request $request, Categoria $categoria)
    {
        $categoria->imagenes()->delete();

        $categoria->delete();
    }
}
