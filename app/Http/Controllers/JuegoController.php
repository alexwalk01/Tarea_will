<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Juego;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class JuegoController extends Controller
{
    public function cargarMasJuegos(Request $request)
    {
        $offset = $request->input('offset', 0);
        $limit = 3;

        $juegos = Auth::user()->juegos()->skip($offset)->take($limit)->get();

        return response()->json($juegos);
    }

    // Todos los juegos
    public function cargarTodosLosJuegos()
    {
        $juegos = Auth::user()->juegos()->get();
        return response()->json($juegos);
    }

    public function index()
    {
        $juegos = Auth::user()->juegos;
        $materias = Auth::user()->materias;
        $proyectos = Auth::user()->proyectos;

        return view('juego.index', compact('juegos', 'materias', 'proyectos'));
    }

    public function descripcion($id)
    {
        $juego = Juego::findOrFail($id);
        $juegos = Auth::user()->juegos;
        $materias = Auth::user()->materias;
        $proyectos = Auth::user()->proyectos;

        return view('juego.descripcion', compact('juego', 'juegos', 'materias', 'proyectos'));
    }

    // Este es el método que se usa para mostrar la descripción del juego
    public function show($id)
    {
        $juego = Juego::findOrFail($id); // Obtiene la materia por ID
        return view('juego.descripcion', compact('juego')); // Pasar los datos a la vista
    }

    public function create()
    {
        $usuarios = User::all(); // Obtener todos los usuarios
        return view('juego.create', compact('usuarios')); // Pasar la variable 'usuarios' a la vista
    }

    public function store(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'usuario_id' => 'required|exists:users,id', // Validar que el usuario exista
        ]);

        // Crear el nuevo juego y asociar el usuario
        Juego::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'user_id' => $request->usuario_id, // Aquí se asigna el usuario
        ]);

        // Redirigir a la lista de juegos
        return redirect()->route('juegos.index')->with('success', 'Juego creado con éxito');
    }

    public function edit($id)
    {
        $juego = Juego::findOrFail($id);
        $usuarios = User::all(); // Obtener usuarios para asignar a un juego
        return view('juego.edit', compact('juego', 'usuarios'));
    }

    // Actualizar un juego
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required',
            'descripcion' => 'required'
        ]);

        $juego = Juego::findOrFail($id);
        $juego->update($request->all()); // Actualizar el juego

        return redirect()->route('juegos.index')->with('success', 'Juego actualizado correctamente.');
    }

    public function buscar(Request $request)
    {
        $nombre = $request->input('nombre');

        $juegos = Juego::where('nombre', 'like', '%' . $nombre . '%')->get();

        return view('juego.index', compact('juegos'));
    }

    public function destroy($id)
    {
        $juego = Juego::findOrFail($id);
        $juego->delete();

        return redirect()->route('juegos.index')->with('success', 'Juego eliminada correctamente.');
    }
}
