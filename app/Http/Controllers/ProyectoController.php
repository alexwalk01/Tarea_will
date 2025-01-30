<?php
namespace App\Http\Controllers;

use App\Models\Proyecto;
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
    $proyecto = Proyecto::findOrFail($id); // Obtiene la materia por ID
    return view('proyecto.descripcion', compact('proyecto')); // Pasar los datos a la vista
}
}
