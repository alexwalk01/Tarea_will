<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Validar la entrada
        $credentials = $request->only('email', 'password');

        // Intentar hacer login con las credenciales proporcionadas
        if (Auth::attempt($credentials)) {
            // El usuario está autenticado, genera el token JWT
            $user = Auth::user();
            $token = JWTAuth::fromUser($user);

            // Retorna el token y los datos del usuario
            return response()->json(compact('token'));
        }

        // Si no se puede autenticar, retorna error
        return response()->json(['error' => 'Unauthorized'], 401);
    }
}
