<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProyectoController extends Controller
{
    public function index()
    {
        // Obtener todos los proyectos asociados al usuario autenticado
        $proyectos = Auth::user()->proyectos; // Obtener proyectos del usuario autenticado
        return view('proyecto.index', compact('proyectos')); // Pasa los proyectos a la vista index
    }

    public function show($id)
    {
        $proyecto = Proyecto::findOrFail($id); // Obtiene el proyecto por ID
        return view('proyecto.descripcion', compact('proyecto')); // Pasar los datos a la vista
    }

    public function descripcion($id)
    {
        $proyecto = Proyecto::findOrFail($id); // Obtiene el proyecto por ID
        return view('proyecto.descripcion', compact('proyecto')); // Pasar los datos a la vista
    }

    public function create()
    {
        $usuarios = User::all();  // Obtener todos los usuarios
        return view('proyecto.create', compact('usuarios'));  // Pasar los usuarios a la vista
    }


    public function store(Request $request)
{
    $request->validate([
        'nombre' => 'required|string|max:255',
        'descripcion' => 'nullable|string',
        'user_id' => 'required|exists:users,id',  // Validar que el usuario existe
    ]);

    // Crear el proyecto y asignarlo al usuario
    Proyecto::create([
        'nombre' => $request->nombre,
        'descripcion' => $request->descripcion,
        'user_id' => $request->user_id,  // Asignar el usuario seleccionado
    ]);

    return redirect()->route('proyectos.index')->with('success', 'Proyecto creado correctamente.');
}


    // Actualizar el proyecto
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        $proyecto = Proyecto::findOrFail($id); // Encuentra el proyecto por ID
        $proyecto->update([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
        ]);

        return redirect()->route('proyectos.index')->with('success', 'Proyecto actualizado correctamente.');
    }
}
