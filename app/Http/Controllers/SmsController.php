<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Twilio\Rest\Client;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SmsController extends Controller
{
    public function index()
    {
        return view('sms.form');
    }
    public function sendSms(Request $request)
    {
        $request->validate([
            'phone' => 'required|regex:/^[0-9]{10}$/'
        ]);
    
        $user = DB::table('users')->where('phone', $request->phone)->first();
    
        if (!$user) {
            return back()->with('error', 'Número de teléfono no registrado.');
        }
    
        // Validación de variables de entorno
        $sid = env('TWILIO_SID');
        $token = env('TWILIO_AUTH_TOKEN');
        $twilioNumber = env('TWILIO_PHONE');
    
        if (!$sid || !$token || !$twilioNumber) {
            return back()->with('error', 'Configuración de Twilio incompleta. Verifica tu archivo .env');
        }
    
        $client = new Client($sid, $token);
        $verificationCode = random_int(100000, 999999); // Usar `random_int()` en lugar de `rand()` por mayor seguridad.
    
        try {
            $client->messages->create(
                '+52' . $request->phone,
                [
                    'from' => $twilioNumber,
                    'body' => "Tu código de verificación es: $verificationCode"
                ]
            );
    
            // **Eliminar cualquier token previo antes de insertar uno nuevo**
            DB::table('password_reset_tokens')->where('email', $user->email)->delete();
    
            // **Insertar el nuevo código en la base de datos**
            DB::table('password_reset_tokens')->insert([
                'email' => $user->email,
                'token' => bcrypt($verificationCode), // Se recomienda cifrar el token por seguridad.
                'phone' => $request->phone,
                'created_at' => now()
            ]);
    
            return redirect()->route('sms.verify')->with([
                'phone' => $request->phone,
                'success' => 'Código enviado. Ingresa el código para continuar.'
            ]);
        } catch (\Exception $e) {
            return back()->with('error', 'Error al enviar SMS: ' . $e->getMessage());
        }
    }
    

    public function showVerificationForm()
    {
        return view('sms.verify');
    }

    public function verifyCode(Request $request)
    {
        $request->validate([
            'phone' => 'required|regex:/^[0-9]{10}$/',
            'codigo' => 'required|digits:6'
        ]);
    
        // **Buscar el código en la base de datos**
        $tokenEntry = DB::table('password_reset_tokens')
            ->where('phone', $request->phone)
            ->first();
    
        if (!$tokenEntry) {
            return redirect()->route('sms.verify')->with([
                'error' => 'Código incorrecto o expirado.',
                'phone' => $request->phone
            ]);
        }
    
        // **Verificar si el código ingresado coincide con el código encriptado**
        if (!Hash::check($request->codigo, $tokenEntry->token)) {
            return redirect()->route('sms.verify')->with([
                'error' => 'Código incorrecto.',
                'phone' => $request->phone
            ]);
        }
    
        // **Verificar si el código ha expirado (ejemplo: 10 minutos de validez)**
        $codigoExpirado = now()->diffInMinutes($tokenEntry->created_at) > 10;
    
        if ($codigoExpirado) {
            DB::table('password_reset_tokens')->where('phone', $request->phone)->delete();
            return redirect()->route('sms.verify')->with([
                'error' => 'El código ha expirado. Solicita uno nuevo.',
                'phone' => $request->phone
            ]);
        }
    
        // **Generar un nuevo token de 60 caracteres**
        $secureToken = Str::random(60);
    
        // **Eliminar el código de 6 dígitos y actualizar con el token largo**
        DB::table('password_reset_tokens')
            ->where('phone', $request->phone)
            ->update([
                'token' => $secureToken,
                'created_at' => now()
            ]);
    
        // **Redirigir al formulario de restablecimiento de contraseña**
        return redirect()->route('password.reset', [
            'token' => $secureToken,
            'email' => $tokenEntry->email
        ])->with('success', 'Código verificado. Ahora puedes restablecer tu contraseña.');
    }
}