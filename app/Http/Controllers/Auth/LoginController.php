<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/home';

    public function username()
    {
        return 'email';
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Iniciar sesión, generar token único por usuario y guardarlo en la base de datos.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'No autorizado'], 401);
            }

            // Obtener usuario autenticado con JWT
            $user = JWTAuth::user();

            // Verificar que el usuario fue autenticado correctamente
            if (!$user) {
                return response()->json(['error' => 'Usuario no encontrado'], 404);
            }

            // Guardar el token y su fecha de expiración en la base de datos
            $user->remember_token = Hash::make($token);
            $user->token_expiration = Carbon::now()->addMinutes(3);
            $user->save();

            // Autenticar usuario con Auth para manejar sesiones
            Auth::login($user);

            // Verificar si la solicitud es JSON (API) o desde el navegador
            if ($request->expectsJson()) {
                return $this->respondWithToken($token);
            }

            // Redirigir al home si la solicitud proviene del navegador
            return redirect()->intended('/home');

        } catch (JWTException $e) {
            return response()->json(['error' => 'No se pudo crear el token'], 500);
        }
    }

    /**
     * Responder con el token JWT.
     *
     * @param string $token
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => 180, // 3 minutos en segundos
        ]);
    }

    /**
     * Verificar el estado de la sesión y cerrar sesión si el token ha expirado.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkSession(Request $request)
    {
        $user = Auth::user();

        if ($user) {
            // Verificar si el token ha expirado
            if (Carbon::now()->greaterThan($user->token_expires_at)) {
                Auth::logout(); // Cerrar sesión
                return response()->json(['error' => 'Sesión expirada'], 401);
            }
            return response()->json(['message' => 'Sesión activa']);
        }

        return response()->json(['error' => 'Usuario no autenticado'], 401);
    }

    /**
     * Cerrar sesión.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/login')->with('message', 'Sesión cerrada correctamente');
    }
}
