<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Juego;
use App\Models\Materia;
use App\Models\Proyecto;
use Illuminate\Support\Facades\Auth;

class BusquedaController extends Controller
{
    public function buscar(Request $request)
    {
        $query = $request->input('nombre');
        $categoria = $request->input('categoria');

        $resultados = [];

        switch ($categoria) {
            case 'juegos':
                $resultados = $this->buscarEnModelo(Juego::class, $query);
                break;
            case 'materias':
                $resultados = $this->buscarEnModelo(Materia::class, $query);
                break;
            case 'proyectos':
                $resultados = $this->buscarEnModelo(Proyecto::class, $query);
                break;
            default:
                break;
        }

        return view('resultados', compact('resultados', 'query', 'categoria'));
    }

    private function buscarEnModelo($modelo, $query)
    {
        $resultados = [];
        $usuario_id = Auth::id();

        $items = $modelo::where('user_id', $usuario_id)->get();

        foreach ($items as $item) {
            if (stripos($item->nombre, $query) !== false || stripos($item->descripcion, $query) !== false) {
                // Verifica si el resultado ya existe en el array
                if (!isset($resultados[$item->id])) {
                    $resultados[$item->id] = [
                        'modelo' => $modelo,
                        'resultado' => $item,
                        'coincidencia' => stripos($item->nombre, $query) !== false ? 'nombre' : 'descripcion',
                        'fragmento_descripcion' => $this->generarFragmento($item->descripcion, $query)
                    ];
                }
            }
        }
        return array_values($resultados); // Devuelve los resultados como un array simple
    }

    private function generarFragmento($descripcion, $query)
    {
        $posicion = stripos($descripcion, $query);
        if ($posicion !== false) {
            $inicio = max(0, $posicion - 50);
            $fin = min(strlen($descripcion), $posicion + strlen($query) + 50);
            return "..." . substr($descripcion, $inicio, $fin - $inicio) . "...";
        } else {
            return substr($descripcion, 0, 100) . "...";
        }
    }
}
