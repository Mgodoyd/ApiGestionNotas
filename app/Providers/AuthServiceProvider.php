<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
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
        User::class => UserPolicy::class,
        Notes::class => NotesPolicy::class, //Agregamos la clase NotesPolicy
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot() 
    {
        $this->registerPolicies();

        Gate::define('access-owner', function ($user) {
            $rolId = $user->rol_id; // Obtener el rol_id del usuario autenticado
            return $rolId === 1; // Si el rol_id es 1 (dueño), se permite el acceso completo
        });
        
        
       // Passport::routes();
        Passport::tokensExpireIn(Carbon::now()->addMinutes(30)); //tiempo de expiracion del token
        Passport::refreshTokensExpireIn(Carbon::now()->addDays(30));
        Passport::enableImplicitGrant();

       Passport::tokensCan([
          // 'read-notes' => 'Ver notas', 
          //  'manage-notes' => 'Crear, ver, actualizar y eliminar notas',
            'manage-rol-state' => 'ver los roles y estados disponibles',
            'manage-account' => 'Obtener la informacion de la cuenta, nombre, email, estado (sin contraseña), modificar datos como email, nombre y contraseña.',
            'update' => 'actualizar notas',
            'store' => 'crear notas',
            'destroy' => 'eliminar notas',
        ]);
    
       /* Passport::setDefaultScope([
            'read-notes'
        ]);
    
        Passport::tokensCan([
            'manage-notes' => 'Manage notes scope', //Crear, ver, actualizar y eliminar notas
        ]);
    
        Passport::tokensCan([
            'manage-account' => 'Manage account scope', 
        ]);
    
        Passport::tokensCan([
            'manage-rol-state' => 'Manage rol state scope',
        ]);
    
        Passport::tokensCan([
            'update-notes' => 'Update notes scope',
        ]);
    
        Passport::tokensCan([
            'read-notes' => 'Read notes scope',
        ]);
        
       /* Passport::tokensCan([
            'owner' => 'Owner scope', 
        ]);
        
        Passport::tokensCan([
            'author' => 'Author scope',
        ]);
    
        Passport::tokensCan([
            'writer' => 'Writer scope',
        ]);
    
        Passport::tokensCan([
            'reader' => 'Reader scope',
        ]);*/
    }
}
