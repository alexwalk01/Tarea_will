<?php

// app/Http/Controllers/BusquedaController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Juego;
use App\Models\Materia;
use App\Models\Proyecto;

class BusquedaController extends Controller
{
    public function buscar(Request $request)
    {
        $query = $request->input('nombre');
        $categoria = $request->input('categoria');

        switch ($categoria) {
            case 'juegos':
                $resultados = Juego::where('nombre', 'LIKE', "%{$query}%")->get();
                break;
            case 'materias':
                $resultados = Materia::where('nombre', 'LIKE', "%{$query}%")->get();
                break;
            case 'proyectos':
                $resultados = Proyecto::where('nombre', 'LIKE', "%{$query}%")->get();
                break;
            default:
                $resultados = collect();
                break;
        }

        return view('resultados', compact('resultados', 'query', 'categoria'));
    }
}


