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
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt($credentials)) {
        $user = Auth::user();

        // Si MFA está deshabilitado, entrar directo sin verificar correo
        if (!$user->mfa_enabled) {
            return redirect()->route('menu.index');
        }

        // Si MFA está habilitado, enviar verificación
        Auth::logout();
        session(['mfa_pending' => $user->id]);

        // Asegúrate de que el correo solo se envíe si MFA está habilitado
        if ($user->mfa_enabled) {
            $user->sendEmailVerificationNotification(); // Solo cuando MFA está habilitado
        }

        return view('auth.verification_notice'); // Mostrar la vista solo cuando MFA está habilitado
    }

    return back()->withErrors(['email' => 'Credenciales incorrectas.']);
}




public function toggleMFA(Request $request)
{
    $user = Auth::user();
    
    // Asegurar que el valor sea 1 o 0 y actualizar
    $user->mfa_enabled = $request->has('mfa_enabled') ? 1 : 0;
    $user->save();

    // Si desactiva MFA, eliminar la sesión pendiente
    if ($user->mfa_enabled == 0) {
        session()->forget('mfa_pending');
    }

    return redirect()->back()->with('status', 'Configuración actualizada con exito!.');
}

}
