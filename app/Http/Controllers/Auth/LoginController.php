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
        $user = User::where('verification_code', $verificationCode)->first();

        if (!$user) {
            return response()->json(['error' => 'Código de verificación inválido'], 400);
        }

        if (Carbon::now()->greaterThan($user->verification_expires_at)) {
            $user->verification_code = null;
            $user->verification_expires_at = null;
            $user->save();
            return response()->json(['error' => 'Código de verificación expirado'], 400);
        }

        $user->verification_code = null;
        $user->verification_expires_at = null;
        $user->save();

        try {
            if (!$token = JWTAuth::fromUser($user)) {
                return response()->json(['error' => 'No autorizado'], 401);
            }

            // Guardar el token y su fecha de expiración en la base de datos
            $user->remember_token = Hash::make($token);
            $user->token_expiration = Carbon::now()->addMinutes(3);
            $user->save();

            // Autenticar usuario con Auth para manejar sesiones
            Auth::login($user);

            return $this->respondWithToken($token);

        } catch (JWTException $e) {
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