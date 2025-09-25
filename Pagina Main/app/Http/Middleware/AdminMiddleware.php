<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Middleware para verificar que el usuario sea administrador
 */
class AdminMiddleware
{
    /**
     * Manejar una petición entrante
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            return redirect()->route('home')->with('error', 'No tienes permisos para acceder a esta sección');
        }

        return $next($request);
    }
}