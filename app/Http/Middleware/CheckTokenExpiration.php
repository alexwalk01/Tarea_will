<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CheckTokenExpiration
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        // Verificar si el usuario está autenticado y si el token ha expirado
        if ($user && $user->token_expiration && Carbon::now()->greaterThan($user->token_expiration)) {
            Auth::logout(); // Cerrar sesión
            return redirect('/token-expired')->with('message', 'Su tiempo ha Expirado'); // Redirigir a la vista de error
        }

        return $next($request);
    }
}
