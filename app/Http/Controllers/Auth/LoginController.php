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
            return redirect()->route('login')->with('error', 'Credenciales incorrectas.');
        }

        if (!Hash::check($credentials['password'], $user->password)) {
            return redirect()->route('login')->with('error', 'Credenciales incorrectas.');
        }

        // Verificar si MFA está habilitado para el usuario
        if ($user->mfa_enabled) {
            // Generar un código de verificación para MFA
            $verificationCode = Str::random(60);
            $user->verification_code = $verificationCode;
            $user->verification_expires_at = Carbon::now()->addMinutes(5); // Expira en 5 minutos
            $user->save();

            // Enviar correo electrónico de verificación
            Mail::send('emails.verify', ['user' => $user, 'verificationCode' => $verificationCode], function ($message) use ($user) {
                $message->to($user->email);
                $message->subject('Confirmación de inicio de sesión');
            });

            // Redirigir al usuario a la página de verificación
            return view('verification_sent');
        }

        // Si MFA no está habilitado, proceder con el flujo normal
        Auth::login($user);

        // Redirigir al panel de administración si el usuario es admin
        if ($user->role === 'admin') {
            return redirect()->route('admin.index');
        }

        // Redirigir a la página principal por defecto
        return redirect()->route('home');
    } catch (\Exception $e) {
        return redirect()->route('login')->with('error', 'Error interno del servidor');
    }
}

    public function authenticated(Request $request, $user)
    {
        $currentSessionId = session()->getId();

        // Verificar si el usuario tiene una sesión activa en otro dispositivo
        if ($user->session_id && $user->session_id !== $currentSessionId) {
            event(new SessionTerminated($user->id));
            DB::table('sessions')->where('id', $user->session_id)->delete();
        }

        // Actualizar la sesión del usuario
        $user->session_id = $currentSessionId;
        $user->save();

        // Redirigir al panel de administración si el usuario es admin
        if ($user->role === 'admin') {
            return redirect()->route('admin.index');
        }

        // Redirigir a la página principal por defecto
        return redirect()->intended($this->redirectPath());
    }
    public function logout(Request $request)
    {
        if ($request->has('duplicate_session')) {
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

    // Eliminar el código de verificación después de la validación
    $user->verification_code = null;
    $user->verification_expires_at = null;
    $user->save();

    try {
        // Generar el JWT
        if (!$token = JWTAuth::fromUser($user)) {
            return redirect()->route('login')->with('error', 'No autorizad');
        }

        $user->remember_token = Hash::make($token);
        $user->token_expiration = Carbon::now()->addMinutes(15);
        $user->save();

        Auth::login($user);

        // Redirigir al panel de administración si el usuario es admin
        if ($user->role === 'admin') {
            return redirect()->route('admin.index');
        }

        // Redirigir a la página principal por defecto
        return redirect()->route('home');
    } catch (JWTException $e) {
        return redirect()->route('login')->with('error', 'No se pudo crear el token');
    }
}

}
