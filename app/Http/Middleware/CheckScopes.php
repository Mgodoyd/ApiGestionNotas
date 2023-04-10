<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;

class CheckScopes
{
    public function handle($request, Closure $next, ...$scopes)
    {
        if (!$request->user() || !$request->user()->token()) {
            return response()->json(['error' => 'No autenticado'], 401);
        }
    
        foreach ($scopes as $scope) {
            if (!$request->user()->tokenCan($scope)) {
                return response()->json(['error' => 'No autorizado'], 403);
            }
        }
    
        return $next($request);
    }
}

