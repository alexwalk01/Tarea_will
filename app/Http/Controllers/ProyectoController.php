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
        $proyectos = Auth::user()->proyectos;
        $juegos = Auth::user()->juegos;
        $materias = Auth::user()->materias;

        return view('proyecto.index', compact('proyectos', 'juegos', 'materias'));
    }

    public function descripcion($id)
    {
        $proyecto = Proyecto::findOrFail($id);
        $juegos = Auth::user()->juegos;
        $materias = Auth::user()->materias;
        $proyectos = Auth::user()->proyectos;

        return view('proyecto.descripcion', compact('proyecto', 'juegos', 'materias', 'proyectos'));
    }

    public function show($id)
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
