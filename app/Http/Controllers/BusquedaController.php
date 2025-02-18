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

        if ($categoria === 'all' || $categoria === null) {
            $resultados = array_merge(
                $this->buscarEnModelo(Juego::class, $query),
                $this->buscarEnModelo(Materia::class, $query),
                $this->buscarEnModelo(Proyecto::class, $query)
            );
        } else {
            $resultados = $this->buscarEnModelo(
                $this->getModeloPorCategoria($categoria),
                $query
            );
        }

        return response()->json(['resultados' => $resultados]); // Respuesta en JSON
    }

    private function buscarEnModelo($modelo, $query)
    {
        $usuario_id = Auth::id();

        $items = $modelo::where('user_id', $usuario_id)
            ->where(function ($q) use ($query) {
                $q->where('nombre', 'LIKE', "%" . $query . "%")
                  ->orWhere('descripcion', 'LIKE', "%" . $query . "%");
            })
            ->get();

        return $items->map(function ($item) use ($modelo, $query) {
            return [
                'modelo' => $modelo,
                'resultado' => $item,
                'coincidencia' => stripos($item->nombre, $query) !== false ? 'nombre' : 'descripcion',
                'fragmento_descripcion' => $this->generarFragmento($item->descripcion, $query),
            ];
        })->toArray();
    }


    private function generarFragmento($descripcion, $query)
    {
        $descripcion = strip_tags($descripcion); // Elimina etiquetas HTML
        $posicion = stripos($descripcion, $query);

        if ($posicion !== false) {
            $inicio = max(0, $posicion - 50);
            $fin = min(strlen($descripcion), $posicion + strlen($query) + 50);
            return "..." . substr($descripcion, $inicio, $fin - $inicio) . "...";
        } else {
            return substr($descripcion, 0, 100) . "...";
        }
    }

    private function getModeloPorCategoria($categoria)
    {
        switch ($categoria) {
            case 'juegos':
                return Juego::class;
            case 'materias':
                return Materia::class;
            case 'proyectos':
                return Proyecto::class;
            default:
                return null;
        }
    }
}
