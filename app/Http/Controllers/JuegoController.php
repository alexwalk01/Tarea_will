<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Juego;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class JuegoController extends Controller
{
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

        return redirect()->route('admin.index')->with('success', 'Juego creado con éxito');
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

        return redirect()->route('admin.index')->with('success', 'Juego actualizado correctamente.');
    }
}
