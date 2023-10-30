<?php

namespace App\Policies;

use App\Models\Usuario;
use App\Models\Roles\Rol;
use App\Models\Menus\Menu;

use Illuminate\Auth\Access\Response;

use Illuminate\Auth\Access\HandlesAuthorization;

class UsuarioPolicy
{
    use HandlesAuthorization;

    public function verificarPermisosModulo(Usuario $usuario, $accion = "ver")
    {
        $rolNombre = Rol::find($usuario->id_rol)->nombre ?? "";

        if (($usuario->id_rol === 0) || ($rolNombre === "Administrador")) {
            return true;
        } else {
            $menus = Menu::leftJoin("roles_menus", "menus.id", "=", "roles_menus.id_menu")
                ->where("roles_menus.id_rol", "=", $usuario->id_rol)
                ->where("roles_menus.$accion", "=", 1)
                ->where("menus.url", "=", "admin/usuarios")
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
     * @param  \App\Models\Usuario  $usuario
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(Usuario $usuario, Usuario $usuarioParaVer)
    {
        if ($this->verificarPermisosModulo($usuario, "ver") === false) {
            return false
                    ? Response::allow()
                    : Response::deny('Sin privilegios para realizar esta acción.');
        }

        return $usuario->id_empresa === $usuarioParaVer->id_empresa
                    ? Response::allow()
                    : Response::deny('Este usuario no pertenece a esta empresa');
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
     * @param  \App\Models\Usuario  $usuarioParaEditar
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(Usuario $usuario, Usuario $usuarioParaEditar)
    {
        if ($this->verificarPermisosModulo($usuario, "editar") === false) {
            return false
                    ? Response::allow()
                    : Response::deny('Sin privilegios para realizar esta acción.');
        }

        return $usuario->id_empresa === $usuarioParaEditar->id_empresa
                        ? Response::allow()
                        : Response::deny('Este usuario no pertenece a esta empresa');
    }
}
