<?php

namespace App\Http\Controllers;

use App\Models\Materia;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MateriaController extends Controller
{
    public function index()
    {
        $materias = Auth::user()->materias;
        $juegos = Auth::user()->juegos;
        $proyectos = Auth::user()->proyectos;

        return view('materia.index', compact('materias', 'juegos', 'proyectos'));
    }

    public function descripcion($id)
    {
        $materia = Materia::findOrFail($id);
        $juegos = Auth::user()->juegos;
        $materias = Auth::user()->materias;
        $proyectos = Auth::user()->proyectos;

        return view('materia.descripcion', compact('materia', 'juegos', 'materias', 'proyectos'));
    }
    // Este es el método que se usa para mostrar la descripción de la materia
    public function show($id)
    {
        $materia = Materia::findOrFail($id); // Obtiene la materia por ID
        return view('materia.descripcion', compact('materia')); // Pasar los datos a la vista
    }

    public function create()
    {
        // Obtener todos los usuarios
        $usuarios = User::all();  // Asegúrate de que el modelo User esté correctamente importado
        return view('materia.create', compact('usuarios'));
    }

    // Guardar una nueva materia
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'user_id' => 'required|exists:users,id', // Validar que el usuario exista
        ]);

        // Crear la materia asignada al usuario
        Materia::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'user_id' => $request->user_id,  // Asignar el usuario
        ]);

        return redirect()->route('admin.index')->with('success', 'Materia creada correctamente.');
    }

    // Mostrar el formulario de edición
    public function edit($id)
    {
        $materia = Materia::findOrFail($id); // Encuentra la materia por ID
        return view('materia.edit', compact('materia')); // Pasa la materia a la vista
    }

    // Actualizar la materia
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        $materia = Materia::findOrFail($id); // Encuentra la materia por ID
        $materia->update([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
        ]);

        return redirect()->route('materias.index')->with('success', 'Materia actualizada correctamente.');
    }

    public function buscar(Request $request)
    {
        $nombre = $request->input('nombre');

        $materias = Materia::where('nombre', 'like', '%' . $nombre . '%')->get();

        return view('materia.index', compact('materias'));
    }
}
