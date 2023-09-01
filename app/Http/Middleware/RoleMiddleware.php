<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle($request, Closure $next, $role)
    {
        if (!Auth::check() || Auth::user()->role != $role) {
            // redirection si l'utilisateur n'a pas le bon rôle
            return redirect('/');
        }

        return $next($request);
    }
}
