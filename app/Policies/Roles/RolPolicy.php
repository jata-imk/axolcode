<?php

namespace App\Policies\Roles;

use App\Models\Usuario;

use App\Models\Roles\Rol;
use App\Models\Menus\Menu;

use Illuminate\Auth\Access\Response;

use Illuminate\Auth\Access\HandlesAuthorization;

class RolPolicy
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
                ->where("menus.url", "=", "admin/roles")
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
     * @param  \App\Models\Roles\Rol  $rol
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(Usuario $usuario, Rol $rol)
    {
        if ($this->verificarPermisosModulo($usuario, "ver") === false) {
            return false
                    ? Response::allow()
                    : Response::deny('Sin privilegios para realizar esta acción.');
        }

        return $usuario->id_empresa === $rol->id_empresa
                    ? Response::allow()
                    : Response::deny('Este rol no pertenece a esta empresa');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\Usuario  $usuario
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(Usuario $usuario)
    {
        return $this->verificarPermisosModulo($usuario, "crear")
                    ? Response::allow()
                    : Response::deny('Sin privilegios para realizar esta acción.');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\Usuario  $usuario
     * @param  \App\Models\Roles\Rol  $rol
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(Usuario $usuario, Rol $rol)
    {
        if ($this->verificarPermisosModulo($usuario, "editar") === false) {
            return false
                    ? Response::allow()
                    : Response::deny('Sin privilegios para realizar esta acción.');
        }

        return $usuario->id_empresa === $rol->id_empresa
                        ? Response::allow()
                        : Response::deny('Este rol no pertenece a esta empresa');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\Usuario  $usuario
     * @param  \App\Models\Roles\Rol  $rol
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(Usuario $usuario, Rol $rol)
    {
        if ($this->verificarPermisosModulo($usuario, "eliminar") === false) {
            return false
                    ? Response::allow()
                    : Response::deny('Sin privilegios para realizar esta acción.');
        }

        return $usuario->id_empresa === $rol->id_empresa
                        ? Response::allow()
                        : Response::deny('Este rol no pertenece a esta empresa');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\Usuario  $usuario
     * @param  \App\Models\Roles\Rol  $rol
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(Usuario $usuario, Rol $rol)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\Usuario  $usuario
     * @param  \App\Models\Roles\Rol  $rol
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(Usuario $usuario, Rol $rol)
    {
        //
    }
}
