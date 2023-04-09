<?php

namespace App\Http\Middleware;

use App\Models\Rol;
use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class CheckScopes
{
    public function handle(Request $request, Closure $next, ...$scopes): Response
    {
        $user = $request->user();//esta obteniendo el usuario
       
        $rol = $user->roles()->first(); //esta obteniendo el rol del usuario
       // var_dump($rol);
       /* if ($rol == $user) {
            throw new AuthorizationException('This action is unauthorized.');
        }*/
    
        if ($rol->id == 1) {
          // var_dump($rol->id);
            $scopes = ['manage-notes', 'manage-account', 'manage-rol-state', 'update-notes', 'read-notes'];
        } else if ($rol->id == 2) {
            $scopes = ['manage-notes', 'update-notes', 'read-notes'];
        } else if ($rol->id == 3) {
            $scopes = ['manage-notes', 'update-notes'];
        } else if ($rol->id == 4) {
            $scopes = ['read-notes'];
        }
    
        $token = $user->token();
        foreach ($scopes as $scope) {
            if (!$token->can($scope)) {
                return response('Unauthorized action.', 401);
            }
        }
    
        return $next($request);
    }
}
