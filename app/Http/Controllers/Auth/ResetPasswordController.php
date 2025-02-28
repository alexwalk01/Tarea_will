<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    use \Illuminate\Foundation\Auth\ResetsPasswords;

    // Método para actualizar la contraseña
    public function updatePassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed'
        ]);

        // Buscar el token en la base de datos
        $tokenEntry = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (!$tokenEntry) {
            return back()->with('error', 'El token es inválido o ha expirado.');
        }

        // Buscar al usuario por su correo
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()->with('error', 'No se encontró una cuenta con este correo.');
        }

        // Actualizar la contraseña del usuario
        $user->password = Hash::make($request->password);
        $user->save();

        // Eliminar el token después de usarlo
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect()->route('login')->with('success', 'Tu contraseña ha sido restablecida correctamente.');
    }
    
    // Sobrescribir el método reset() si es necesario
    public function reset(Request $request)
    {
        // Tu implementación personalizada
        return $this->updatePassword($request);  // Si quieres que utilice la misma lógica que tu método updatePassword
    }
}
