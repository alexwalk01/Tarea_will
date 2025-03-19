<?php

namespace App\Http\Controllers\Auth;

use App\Events\SessionTerminated;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
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

    public function authenticated(Request $request, $user)
    {
        $currentSessionId = session()->getId();

        if ($user->session_id && $user->session_id !== $currentSessionId) {
            event(new SessionTerminated($user->id));
            DB::table('sessions')->where('id', $user->session_id)->delete();
        }

        $user->session_id = $currentSessionId;
        $user->save();
    }

    public function logout(Request $request)
    {
        if($request->has('duplicate_session')){
            $user = Auth::user();
            event(new SessionTerminated($user->id));
            Auth::logout();
            return redirect('/login')->with('message', 'Tu sesión ha sido cerrada porque se inició sesión en otro dispositivo.');
        }

        Auth::logout();
        return redirect('/login')->with('message', 'Sesión cerrada correctamente');
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => 180, // 3 minutos en segundos
        ]);
    }

    public function verify(Request $request, $verificationCode)
    {
        $user = User::where('verification_code', $verificationCode)->first();

        if (!$user) {
            return redirect()->route('login')->with('error', 'El código de verificación es inválido o ha caducado.');
        }

        if (Carbon::now()->greaterThan($user->verification_expires_at)) {
            $user->verification_code = null;
            $user->verification_expires_at = null;
            $user->save();
            return redirect()->route('login')->with('error', 'El código de verificación ha expirado. Intenta de nuevo.');
        }

        $user->verification_code = null;
        $user->verification_expires_at = null;
        $user->save();

        try {
            // Verificar y eliminar sesión anterior si existe
            DB::table('sessions')->where('user_id', $user->id)->delete();

            if (!$token = JWTAuth::fromUser($user)) {
                return response()->json(['error' => 'No autorizado'], 401);
            }

            $user->remember_token = Hash::make($token);
            $user->token_expiration = Carbon::now()->addMinutes(3);
            $user->save();

            Auth::login($user);

            return redirect()->route('home');
        } catch (JWTException $e) {
            return response()->json(['error' => 'No se pudo crear el token'], 500);
        }
    }

    // public function authenticated(Request $request, $user)
    // {
    //     $currentSessionId = session()->getId();

    //     // Si el usuario ya tiene una sesión activa en otro dispositivo
    //     if ($user->session_id && $user->session_id !== $currentSessionId) {
    //         // Notificar al dispositivo antiguo (puedes crear un evento para esto si lo deseas)
    //         // Cerrar la sesión en el dispositivo antiguo
    //         \DB::table('sessions')->where('id', $user->session_id)->delete();

    //         // Aquí guardamos el mensaje para que se muestre en el siguiente request
    //         session()->flash('message', 'Tu sesión ha sido cerrada porque se inició sesión en otro dispositivo.');
    //     }

    //     // Actualizar el session_id del usuario
    //     $user->session_id = $currentSessionId;
    //     $user->save();
    // }
}
