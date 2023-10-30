<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        'App\Models\Clientes\Cliente' => 'App\Policies\Clientes\ClientePolicy',
        'App\Models\Usuario' => 'App\Policies\UsuarioPolicy',
        'App\Models\Roles\Rol' => 'App\Policies\Roles\RolPolicy',
        'App\Models\Empresas\Empresa' => 'App\Policies\Empresas\EmpresaPolicy',
        'App\Models\Excursiones\Excursion' => 'App\Policies\Excursiones\ExcursionPolicy',
        'App\Models\Promociones\Promocion' => 'App\Policies\Promociones\PromocionPolicy',
        'App\Models\Perfiles\Perfil' => 'App\Policies\Perfiles\PerfilPolicy',
        'App\Models\Salas\Sala' => 'App\Policies\Salas\SalaPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
    }
}
