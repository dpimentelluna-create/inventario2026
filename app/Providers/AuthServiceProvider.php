<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('gestionar-usuarios', fn(User $usuario) => $usuario->activo && $usuario->esAdministrador());
        Gate::define('registrar', fn(User $usuario) => $usuario->activo && $usuario->puedeRegistrar());
        Gate::define('gestionar-bajas', fn(User $usuario) => $usuario->activo && $usuario->esAdministrador());
        
        //Administrador y registrador pueden eliminar
        Gate::define('eliminar', fn (User $usuario) => $usuario->activo && $usuario->puedeEliminar());

        //Solo administradores pueden eliminar
        //Gate::define('eliminar', fn(User $usuario) => $usuario->activo && $usuario->puedeEliminar());
    }
}
