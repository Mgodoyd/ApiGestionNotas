<?php

namespace App\Providers;

use App\Mail\UserCreated;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
       // Schema::defaultStringLength(191);

       User::created(function ($user) {  //se ejecuta cuando se crea un usuario y se le pasa el usuario creado como parametro para enviar el correo
            retry(5,function() use ($user){
                Mail::to($user)->send(new UserCreated($user));
                },100);
            });
    }
}
