<?php

namespace App\Http\Middleware;

use Closure;

class RemoveCorsHeaderFromLogin
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        if ($request->is('api/login')) {
            $response->headers->remove('Access-Control-Allow-Origin');
        }

        return $response;
    }
}
