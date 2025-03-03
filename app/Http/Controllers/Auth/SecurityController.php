<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class SecurityController extends Controller
{
    public function showForm()
    {
        return view('auth.passwords.security');
    }

    public function verifyAnswers(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'security_answer_1' => 'required|string',
            'security_answer_2' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || 
            $user->security_answer_1 !== $request->security_answer_1 || 
            $user->security_answer_2 !== $request->security_answer_2) {
            return back()->withErrors(['error' => 'Las respuestas no coinciden.']);
        }

        return view('auth.passwords.reset-security', ['email' => $request->email]);
    }
    public function updatePassword(Request $request)
{
    $request->validate([
        'email' => 'required|email|exists:users,email',
        'password' => 'required|string|min:8|confirmed',
    ]);

    $user = User::where('email', $request->email)->first();
    $user->password = Hash::make($request->password);
    $user->save();

    return redirect()->route('login')->with('status', 'Contraseña actualizada correctamente.');
}

}
