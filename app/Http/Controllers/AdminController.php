<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Juego;
use App\Models\Materia;
use App\Models\Proyecto;

class AdminController extends Controller
{
    public function index()
    {
        // Obtener los usuarios, juegos, materias y proyectos
        $usuarios = User::all();
        $juegos = Juego::all();
        $materias = Materia::all();
        $proyectos = Proyecto::all();

        // Pasar todas las variables a la vista
        return view('admin.index', compact('usuarios', 'juegos', 'materias', 'proyectos'));
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
}
