<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Password;
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

    public function reset(Request $request)
    {
       // \Log::info('Reset password request received', $request->all());

        $response = $this->broker()->reset(
            $this->credentials($request),
            function ($user, $password) {
              //  \Log::info('Updating password for user: ' . $user->email);
                $this->resetPassword($user, $password);
            }
        );

        //\Log::info('Reset password response: ' . $response);

        return $response == Password::PASSWORD_RESET
            ? $this->sendResetResponse($request, $response)
            : $this->sendResetFailedResponse($request, $response);
    }
}
