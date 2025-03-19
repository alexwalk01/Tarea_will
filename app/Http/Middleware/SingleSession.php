<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class SingleSession
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $currentSessionId = Session::getId();

            if ($user->session_id && $user->session_id !== $currentSessionId) {
                Auth::logout();
                Session::invalidate();
                return redirect('/login')->with('message', 'Tu sesión fue cerrada porque se inició sesión en otro dispositivo.');
            }

            $user->session_id = $currentSessionId;
            $user->save();
        }

        return $next($request);
    }
}
