<?php

namespace App\Http\Controllers\Menu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Menus\Menu;

class MenuController extends Controller
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
        $menus = Menu::all();

        return view('menus.index', [
            "menus" => $menus
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $keysContenedores = Menu::where("key", "!=", "")->select("key")->get();

        return view('menus.agregar', [
            "keysContenedores" => $keysContenedores
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $modulo = new Menu;

        $columnas = ["text", "icon", "icon_color", "url", "label", "label_color", "key", "add_in", "section"];

        foreach ($columnas as $columna) {
            if ($request->has($columna)) {
                $modulo[$columna] = $request->input($columna) ?? "";
            }
        }

        $modulo->save();

        return redirect()->route('modulos.index');
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
    public function edit($idModulo)
    {
        $modulo = Menu::find($idModulo);
        $keysContenedores = Menu::where("key", "!=", "")->select("key")->get();

        return view('menus.editar', [
            "menu" => $modulo,
            "keysContenedores" => $keysContenedores
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $idModulo)
    {
        $modulo = Menu::find($idModulo);

        $columnas = ["text", "icon", "icon_color", "url", "label", "label_color", "key", "add_in", "section", "active"];

        foreach ($columnas as $columna) {
            if ($request->has($columna)) {
                $modulo[$columna] = $request->input($columna) ?? "";
            }
        }

        $modulo->save();

        if ($request->isMethod("patch")) {
            $requestFiltrado = $request->except(["_method", "_token"]);

            return response()->json([
                'code' => '200',
                'body' => [
                    "id_menu" => $idModulo,
                    "modified" => $requestFiltrado
                ]
            ]);
        } else {
            return redirect()->route('modulos.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
