<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //'App\Models\Model' => 'App\Policies\ModelPolicy',
        Buyer::class => BuyerPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot() 
    {
        $this->registerPolicies();

        Gate::define('admin-action', function ($user) {
            return $user->esAdministrador();
        });

       // Passport::routes();
        Passport::tokensExpireIn(Carbon::now()->addMinutes(30)); //tiempo de expiracion del token
        Passport::refreshTokensExpireIn(Carbon::now()->addDays(30));
        Passport::enableImplicitGrant();

        Passport::tokensCan([
            'update-notes' => 'Actualizar Notas y ver notas',
            'read-notes' => 'Ver notas',
            'manage-notes' => 'Crear, ver, actualizar y eliminar notas',
            'manage-rol-state' => 'ver los roles y estados disponibles',
            'manage-account' => 'Obtener la informacion de la cuenta, nombre, email, estado (sin contraseña), modificar datos como email, nombre y contraseña. No puede eliminar la cuenta',
        ]);
    }
}
