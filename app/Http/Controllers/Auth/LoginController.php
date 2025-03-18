<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

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

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            if (!$user = User::where('email', $credentials['email'])->first()) {
                return response()->json(['error' => 'No autorizado'], 401);
            }

            if (!Hash::check($credentials['password'], $user->password)) {
                return response()->json(['error' => 'No autorizado'], 401);
            }

            // Generar código de verificación
            $verificationCode = Str::random(60);
            $user->verification_code = $verificationCode;
            $user->verification_expires_at = Carbon::now()->addMinutes(2);
            $user->save();

            // Enviar correo electrónico de verificación
            Mail::send('emails.verify', ['user' => $user, 'verificationCode' => $verificationCode], function ($message) use ($user) {
                $message->to($user->email);
                $message->subject('Confirmación de inicio de sesión');
            });

            return view('verification_sent');

        } catch (\Exception $e) {
            return response()->json(['error' => 'Error interno del servidor'], 500);
        }
    }


public function verify(Request $request, $verificationCode)
{
    // Buscar al usuario por el código de verificación
    $user = User::where('verification_code', $verificationCode)->first();

    // Si el usuario no existe, redirigir al login con un mensaje de error
    if (!$user) {
        return redirect()->route('login')->with('error', 'El código de verificación es inválido o ha caducado.');
    }

    // Verificar si el código de verificación ha expirado
    if (Carbon::now()->greaterThan($user->verification_expires_at)) {
        // Limpiar el código de verificación y la fecha de expiración
        $user->verification_code = null;
        $user->verification_expires_at = null;
        $user->save();
        // Redirigir al login con un mensaje de error
        return redirect()->route('login')->with('error', 'El código de verificación ha expirado. Intenta de nuevo.');
    }

    // Limpiar el código de verificación y la fecha de expiración
    $user->verification_code = null;
    $user->verification_expires_at = null;
    $user->save();

    try {
        // Generar un token JWT para el usuario
        if (!$token = JWTAuth::fromUser($user)) {
            // Si no se puede generar el token, devolver un error de no autorizado
            return response()->json(['error' => 'No autorizado'], 401);
        }

        // Guardar el token y su fecha de expiración en la base de datos
        $user->remember_token = Hash::make($token);
        $user->token_expiration = Carbon::now()->addMinutes(3);
        $user->save();

        // Autenticar al usuario con Auth para manejar sesiones
        Auth::login($user);

        // Redirigir al usuario a la página principal (ajusta 'home' según tu ruta)
        return redirect()->route('home');

    } catch (JWTException $e) {
        // Si ocurre un error al generar el token, devolver un error interno del servidor
        return response()->json(['error' => 'No se pudo crear el token'], 500);
    }
}

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => 180, // 3 minutos en segundos
        ]);
    }


    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/login')->with('message', 'Sesión cerrada correctamente');
    }
}