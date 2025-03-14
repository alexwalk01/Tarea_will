<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\LoginConfirmation;
use App\Models\User;
use App\Mail\LoginConfirmationMail;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * Maneja el inicio de sesión con verificación por correo electrónico.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            Auth::logout(); // Desloguear hasta la confirmación
    
            // Generar un token único y expiración en 2 minutos
            $token = Str::random(40);
            $expiresAt = Carbon::now()->addMinutes(2);
    
            // Guardar en la base de datos
            $user->update([
                'email_verification_token' => $token,
                'login_confirmed' => false, // Resetear confirmación
            ]);
    
            LoginConfirmation::updateOrCreate(
                ['user_id' => $user->id],
                ['token' => $token, 'expires_at' => $expiresAt]
            );
    
            // Enviar correo de confirmación
            Mail::to($user->email)->send(new LoginConfirmationMail($user, $token));
    
            return back()->with('message', 'Revisa tu correo para confirmar el inicio de sesión.');
        }
    
        return back()->withErrors(['email' => 'Credenciales incorrectas']);
    }
    


    /**
     */
    // Método para confirmar el login desde el enlace del correo
    public function confirmLogin(Request $request, $token)
    {
        $loginConfirmation = LoginConfirmation::where('token', $token)->first();
    
        if (!$loginConfirmation) {
            return redirect('/login')->with('error', 'Token inválido o expirado.');
        }
    
        // Obtener la fecha de expiración en formato de Carbon
        $expiresAt = Carbon::parse($loginConfirmation->expires_at);
    
        // Verificar si el token ha expirado
        if (Carbon::now()->greaterThan($expiresAt)) {
            // Eliminar el token expirado
            $loginConfirmation->delete();
            return redirect('/login')->with('error', 'El token ha expirado. Inicia sesión nuevamente.');
        }
    
        // Obtener el usuario relacionado con el token
        $user = User::find($loginConfirmation->user_id);
        
        if (!$user) {
            return redirect('/login')->with('error', 'Usuario no encontrado.');
        }
    
        // Si el usuario hizo clic en "Sí soy yo"
        if ($request->query('confirm') === 'yes') {
            // Marcar el login como confirmado y eliminar el token
            $user->update(['login_confirmed' => true]);
            $loginConfirmation->delete();
    
            return redirect('/login')->with('success', 'Acceso confirmado. Ahora puedes iniciar sesión.');
        } 
        // Si el usuario hizo clic en "No soy yo"
        else {
            $user->update(['login_confirmed' => false]);
            $loginConfirmation->delete();
            return redirect('/login')->with('error', 'Inicio de sesión rechazado.');
        }
    }
    

    /**
     * Redirige al usuario después de la autenticación según su rol.
     */
    protected function redirectUser($user)
    {
        if ($user->role === 'admin') {
            return redirect()->route('admin.index');
        }

        if ($user->role === 'user') {
            return redirect()->route('menu.index');
        }

        return redirect('/');
    }

    // Método para verificar la autenticación después del login
    protected function authenticated(Request $request, $user)
    {
        // Si el usuario aún no ha confirmado el login, se le bloquea el acceso
        if (!$user->login_confirmed) {
            Auth::logout(); // Cierra la sesión
            return redirect('/login')->with('error', 'Inicio de sesión rechazado. Confirma tu acceso desde el correo.');
        }

        // Si es admin, redirigir al panel de administración
        if ($user->role === 'admin') {
            return redirect()->route('admin.index');
        }

        // Si es usuario normal, redirigir al menú
        return redirect()->route('menu.index');
    }

}
