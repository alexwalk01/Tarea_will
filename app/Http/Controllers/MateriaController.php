<?php

namespace App\Http\Controllers;

use App\Models\Materia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MateriaController extends Controller
{
    public function index()
    {
        // Obtener todas las materias asociadas al usuario autenticado
        $materias = Auth::user()->materias; // Obtener materias del usuario autenticado
        return view('materia.index', compact('materias')); // Pasa las materias a la vista index
    }

    // Este es el método que se usa para mostrar la descripción de la materia
    public function show($id)
    {
        $materia = Materia::findOrFail($id); // Obtiene la materia por ID
        return view('materia.descripcion', compact('materia')); // Pasar los datos a la vista
    }
    // MateriaController.php
public function descripcion($id)
{
    $materia = Materia::findOrFail($id); // Obtiene la materia por ID
    return view('materia.descripcion', compact('materia')); // Pasar los datos a la vista
}

}
