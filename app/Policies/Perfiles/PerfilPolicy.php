<?php

namespace App\Policies\Perfiles;

use App\Models\Usuario;
use App\Models\Roles\Rol;
use App\Models\Menus\Menu;

use App\Models\Perfiles\Perfil;

use Illuminate\Auth\Access\Response;

use Illuminate\Auth\Access\HandlesAuthorization;

class PerfilPolicy
{
    use HandlesAuthorization;

    public function verificarPermisosModulo(Usuario $usuario, $accion = "ver")
    {
        if (($usuario->id_rol === 0) || ($usuario->rol->nombre === "Administrador")) {
            return true;
        } else {
            $menus = Menu::leftJoin("roles_menus", "menus.id", "=", "roles_menus.id_menu")
                ->where("roles_menus.id_rol", "=", $usuario->id_rol)
                ->where("roles_menus.$accion", "=", 1)
                ->where("menus.url", "=", "admin/mi_perfil")
                ->select("menus.*")
                ->get();

            return ($menus->isNotEmpty());
        }
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\Usuario  $usuario
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(Usuario $usuario)
    {
        return $this->verificarPermisosModulo($usuario, "ver")
            ? Response::allow()
            : Response::deny('Sin privilegios para realizar esta acción.');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\Usuario  $usuario
     * @param  \App\Models\Perfiles\Perfil $perfil
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(Usuario $usuario, Perfil $perfil)
    {
        if ($this->verificarPermisosModulo($usuario, "ver") === false) {
            return false
                ? Response::allow()
                : Response::deny('Sin privilegios para realizar esta acción.');
        }

        return $usuario->id === $perfil->id
            ? Response::allow()
            : Response::deny('Sin privilegios para realizar esta acción');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\Usuario  $usuario
     * @param  \App\Models\Perfiles\Perfil $perfil
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(Usuario $usuario, Perfil $perfil)
    {
        if ($this->verificarPermisosModulo($usuario, "editar") === false) {
            return false
                ? Response::allow()
                : Response::deny('Sin privilegios para realizar esta acción.');
        }

        return $usuario->id === $perfil->id
            ? Response::allow()
            : Response::deny('Sin privilegios para realizar esta acción');
    }
}
