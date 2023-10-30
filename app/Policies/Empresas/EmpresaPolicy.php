<?php

namespace App\Policies\Empresas;

use App\Models\Empresas\Empresa;
use App\Models\Usuario;

use Illuminate\Auth\Access\Response;

use Illuminate\Auth\Access\HandlesAuthorization;

class EmpresaPolicy
{
    use HandlesAuthorization;

    public function verificarPermisosModulo(Usuario $usuario)
    {
        return ($usuario->id_rol === 0);
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\Usuario  $usuario
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(Usuario $usuario)
    {
        return $this->verificarPermisosModulo($usuario)
                    ? Response::allow()
                    : Response::deny('Sin privilegios para realizar esta acción.');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\Usuario  $usuario
     * @param  \App\Models\Empresas\Empresa  $empresa
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(Usuario $usuario, Empresa $empresa)
    {
        return $this->verificarPermisosModulo($usuario)
                    ? Response::allow()
                    : Response::deny('Sin privilegios para realizar esta acción.');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\Usuario  $usuario
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(Usuario $usuario)
    {
        return $this->verificarPermisosModulo($usuario)
                    ? Response::allow()
                    : Response::deny('Sin privilegios para realizar esta acción.');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\Usuario  $usuario
     * @param  \App\Models\Empresas\Empresa  $empresa
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(Usuario $usuario, Empresa $empresa)
    {
        return $this->verificarPermisosModulo($usuario)
                ? Response::allow()
                : Response::deny('Sin privilegios para realizar esta acción.');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\Usuario  $usuario
     * @param  \App\Models\Empresas\Empresa  $empresa
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(Usuario $usuario, Empresa $empresa)
    {
        return $this->verificarPermisosModulo($usuario)
                ? Response::allow()
                : Response::deny('Sin privilegios para realizar esta acción.');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\Usuario  $usuario
     * @param  \App\Models\Empresas\Empresa  $empresa
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(Usuario $usuario, Empresa $empresa)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\Usuario  $usuario
     * @param  \App\Models\Empresas\Empresa  $empresa
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(Usuario $usuario, Empresa $empresa)
    {
        //
    }
}
