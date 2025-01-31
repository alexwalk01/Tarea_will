<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * Redirige al usuario después de la autenticación.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    protected function authenticated(Request $request, $user)
{
    // Si el usuario tiene rol 'admin', redirigir al panel de administración
    if ($user->role === 'admin') {
        return redirect()->route('admin.index'); // Usar route() para obtener la URL correcta
    }

    // Si el usuario tiene rol 'user', redirigir a la vista 'menu'
    if ($user->role === 'user') {
        return redirect()->route('menu.index');
    }

    // Redirigir a la ruta por defecto
    return redirect('/');
}

}
