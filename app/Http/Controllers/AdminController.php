<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Juego;
use App\Models\Materia;
use App\Models\Proyecto;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        $juegos = Juego::all(); // Asegúrate de tener el modelo de Juego
        $materias = Materia::all(); // Asegúrate de tener el modelo de Materia
        $proyectos = Proyecto::all(); // Asegúrate de tener el modelo de Proyecto
        $usuarios = User::all(); // Obtener los usuarios
        $usuarios = User::with(['juegos', 'materias', 'proyectos'])->get();

        // Pasar las variables a la vista
        return view('admin.index', compact('juegos', 'materias', 'proyectos', 'usuarios'));
    }

    public function updateUserPermissions(Request $request, $userId)
    {
        $user = User::findOrFail($userId);

        $user->juegos_permissions = json_encode($request->input('juegos_permissions', []));
        $user->materias_permissions = json_encode($request->input('materias_permissions', []));
        $user->proyectos_permissions = json_encode($request->input('proyectos_permissions', []));

        $user->save();

        return redirect()->back()->with('success', 'Permisos actualizados correctamente.');
    }
    public function showAdminRegisterForm()
    {
        return view('admin.register'); // Carga la vista de registro
    }

    public function registerAdmin(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:255',
            'role' => 'required|string|in:user,admin', // Validar el campo role
            'security_question_1' => 'required|string|max:255',
            'security_answer_1' => 'required|string|max:255',
            'security_question_2' => 'required|string|max:255',
            'security_answer_2' => 'required|string|max:255',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,  // Guardar el rol seleccionado
            'phone' => $request->phone,
            'security_question_1' => $request->security_question_1,
            'security_answer_1' => $request->security_answer_1,
            'security_question_2' => $request->security_question_2,
            'security_answer_2' => $request->security_answer_2,
        ]);

        return redirect()->route('admin.index')->with('success', 'User registered successfully.');
    }
    public function deleteUser($userId)
    {
        $usuario = User::find($userId);
        if (!$usuario) {
            return redirect()->route('admin.index')->with('error', 'Usuario no encontrado');
        }

        $usuario->delete();
        return redirect()->route('admin.index')->with('success', 'Usuario eliminado correctamente');
    }
}
