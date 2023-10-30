<?php

namespace App\Http\Controllers\Roles;

use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Roles\Rol;
use App\Models\Menus\Menu;
use App\Models\RolesMenus\RolMenu;

class RolController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize("viewAny", Rol::class);

        $roles = Rol::where("id_empresa", "=", Auth::user()->id_empresa)
            ->select()
            ->get();

        return view('roles.index', [
            "roles" => $roles
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize("create", Rol::class);

        $modulos = Menu::all();

        return view('roles.agregar', [
            "modulos" => $modulos
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
        $this->authorize("create", Rol::class);

        // Primero creamos el rol en la tabla Roles
        $nuevoRol = new Rol;

        $nuevoRol->id_empresa = Auth::user()->id_empresa;
        $nuevoRol->id_usuario = Auth::user()->id;
        $nuevoRol->nombre = $request->input("nombre");

        $nuevoRol->save();

        // Ahora haremos las relaciones con los menus
        $menus = Menu::all();

        foreach ($menus as $menu) {
            $rolMenu = new RolMenu;

            $rolMenu->id_empresa = Auth::user()->id_empresa;
            $rolMenu->id_usuario = Auth::user()->id;
            $rolMenu->id_rol = $nuevoRol->id;
            $rolMenu->id_menu = $menu->id;

            $rolMenu->crear = $request->input($menu->id . "-crear", "0");
            $rolMenu->ver = $request->input($menu->id . "-ver", "0");
            $rolMenu->editar = $request->input($menu->id . "-editar", "0");
            $rolMenu->eliminar = $request->input($menu->id . "-eliminar", "0");

            $rolMenu->save();
        }

        return redirect()->route('roles.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($idRol)
    {
        $rol = Rol::find($idRol);
        
        $this->authorize("view", $rol);
        
        $rolModulos = Menu::leftJoin("roles_menus", "menus.id", "=", "roles_menus.id_menu")
            ->where("roles_menus.id_rol", "=", $idRol)
            ->select("roles_menus.*")
            ->get();

        $modulos = Menu::all();

        return view('roles.editar', [
            "modulos" => $modulos,
            "rolesModulos" => $rolModulos,
            "rol" => $rol,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $idRol)
    {
        

        $rol = Rol::find($idRol);
        $this->authorize("update", $rol);

        $rol->nombre = $request->input("nombre");

        if ($rol->isDirty()) {
            $rol->save();
        }

        // Ahora actualizamos las relaciones con los menus
        $rolModulos = Menu::leftJoin("roles_menus", "menus.id", "=", "roles_menus.id_menu")
            ->where("roles_menus.id_rol", "=", $idRol)
            ->select("roles_menus.*")
            ->get();

        $rolModulosOriginales = array_column($rolModulos->toArray(), "id_menu");
        $rolModulosActuales = array_column(Menu::all()->toArray(), "id");

        $rolModulosNuevos = array_diff($rolModulosActuales, $rolModulosOriginales);

        //Modulos nuevos
        foreach ($rolModulosNuevos as $rolMenuNuevo) {
            $rolMenu = new RolMenu;

            $rolMenu->id_empresa = Auth::user()->id_empresa;
            $rolMenu->id_usuario = Auth::user()->id;
            $rolMenu->id_rol = $rol->id;
            $rolMenu->id_menu = $rolMenuNuevo;

            $rolMenu->crear = $request->input($rolMenuNuevo . "-crear", "0");
            $rolMenu->ver = $request->input($rolMenuNuevo . "-ver", "0");
            $rolMenu->editar = $request->input($rolMenuNuevo . "-editar", "0");
            $rolMenu->eliminar = $request->input($rolMenuNuevo . "-eliminar", "0");

            $rolMenu->save();
        }

        // Modulos ya existentes
        foreach ($rolModulos as $rolModulo) {
            $rolMenu = RolMenu::find($rolModulo->id);

            $rolMenu->crear = $request->input($rolModulo->id_menu . "-crear", "0");
            $rolMenu->ver = $request->input($rolModulo->id_menu . "-ver", "0");
            $rolMenu->editar = $request->input($rolModulo->id_menu . "-editar", "0");
            $rolMenu->eliminar = $request->input($rolModulo->id_menu . "-eliminar", "0");

            if ($rolMenu->isDirty()) {
                $rolMenu->save();
            }
        }

        return redirect()->route('roles.index');
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
