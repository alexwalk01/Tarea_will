<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Juego;
use Illuminate\Support\Facades\Auth;

class JuegoController extends Controller
{
    // Método para mostrar todos los juegos
    public function index()
    {
        $juegos = Juego::all();
        return view('juego.index', compact('juegos'));
    }

    // Método para mostrar el menú del usuario con sus juegos
    // public function menu()
    // {
    //     $user = Auth::user();
    //     if (!$user) {
    //         return redirect()->route('login')->with('error', 'Debes iniciar sesión.');
    //     }

    //     $juegos = $user->juegos;
    //     return view('menu', compact('juegos'));
    // }

    // Método para mostrar la descripción de un juego específico
    public function descripcion($id)
    {
        $juego = Juego::findOrFail($id); // Busca el juego por ID
        return view('juego.descripcion', compact('juego')); // Pasa la información del juego a la vista
    }
}
