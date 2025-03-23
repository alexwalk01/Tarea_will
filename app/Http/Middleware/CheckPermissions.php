<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckPermissions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $module
     * @param  string  $permission
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $module, $permission)
    {
        $user = auth()->user();

        // Verifica que el usuario esté autenticado
        if (!$user) {
            abort(403, 'No estás autenticado.');
        }

        // Obtiene los permisos del módulo correspondiente
        $permissions = json_decode($user->{$module . '_permissions'}, true) ?? [];

        // Verifica que el permiso exista
        if (!in_array($permission, $permissions)) {
            abort(403, 'No tienes permiso para realizar esta acción.');
        }

        return $next($request);
    }
}

