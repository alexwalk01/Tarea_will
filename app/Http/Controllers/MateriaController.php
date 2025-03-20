<?php

namespace App\Http\Controllers;

use App\Models\Materia;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MateriaController extends Controller
{
    public function cargarMasMaterias(Request $request)
    {
        $offset = $request->input('offset', 0);
        $limit = 3;

        $materias = Auth::user()->materias()->skip($offset)->take($limit)->get();
        return response()->json($materias);
    }

    // Todas las materias
    public function cargarTodasLasMaterias()
    {
        $materias = Auth::user()->materias()->get();
        return response()->json($materias);
    }

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

    public function show($id)
    {
        $materia = Materia::findOrFail($id);
        return view('materia.descripcion', compact('materia'));
    }

    public function create()
    {
        $usuarios = User::all();
        return view('materia.create', compact('usuarios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'user_id' => 'required|exists:users,id',
        ]);

        Materia::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'user_id' => $request->user_id,
        ]);

        return redirect()->route('materias.index')->with('success', 'Materia creada correctamente.');
    }

    public function edit($id)
    {
        $materia = Materia::findOrFail($id);
        return view('materia.edit', compact('materia'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        $materia = Materia::findOrFail($id);
        $materia->update([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
        ]);

        return redirect()->route('materias.index')->with('success', 'Materia actualizada correctamente.');
    }

    public function destroy($id)
    {
        $materia = Materia::findOrFail($id);
        $materia->delete();

        return redirect()->route('materias.index')->with('success', 'Materia eliminada correctamente.');
    }

    public function buscar(Request $request)
    {
        $nombre = $request->input('nombre');
        $materias = Materia::where('nombre', 'like', '%' . $nombre . '%')->get();
        return view('materia.index', compact('materias'));
    }
}
