<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckPermissions
{
    public function handle(Request $request, Closure $next, $permission)
    {
        $user = $request->user();
        $permissions = json_decode($user->{$permission}, true) ?? [];

        // Obtener la acción actual (create, read, update, delete)
        $action = $this->getActionFromRequest($request);

        // Si no tiene permisos o no tiene el permiso específico para esta acción
        if (empty($permissions) || !in_array($action, $permissions)) {
            abort(403, 'No tienes permiso para realizar esta acción.');
        }

        return $next($request);
    }

    protected function getActionFromRequest(Request $request)
    {
        if ($request->isMethod('post')) return 'create';
        if ($request->isMethod('get') && !$request->route()->parameter('id')) return 'read';
        if ($request->isMethod('get') && $request->route()->parameter('id')) return 'read';
        if ($request->isMethod('put') || $request->isMethod('patch')) return 'update';
        if ($request->isMethod('delete')) return 'delete';

        return 'read'; // Por defecto
    }
}
