<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProyectoController extends Controller
{
    public function cargarTodosLosProyectos()
    {
        $proyectos = Auth::user()->proyectos()->get();
        return response()->json($proyectos);
    }

    public function index()
    {
        if (!in_array('read', json_decode(auth()->user()->proyectos_permissions, true) ?? [])) {
            abort(403, 'No tienes permiso para crear proyectos.');
        }
        $proyectos = Auth::user()->proyectos;
        $juegos = Auth::user()->juegos;
        $materias = Auth::user()->materias;

        return view('proyecto.index', compact('proyectos', 'juegos', 'materias'));
    }

    public function descripcion($id)
    {
        if (!in_array('read', json_decode(auth()->user()->proyectos_permissions, true) ?? [])) {
            abort(403, 'No tienes permiso para crear proyectos.');
        }
        $proyecto = Proyecto::findOrFail($id);
        $juegos = Auth::user()->juegos;
        $materias = Auth::user()->materias;
        $proyectos = Auth::user()->proyectos;

        return view('proyecto.descripcion', compact('proyecto', 'juegos', 'materias', 'proyectos'));
    }

    public function show($id)
    {
        $proyecto = Proyecto::findOrFail($id);
        return view('proyecto.descripcion', compact('proyecto'));
    }

    public function create()
    {
        if (!in_array('create', json_decode(auth()->user()->proyectos_permissions, true) ?? [])) {
            abort(403, 'No tienes permiso para crear proyectos.');
        }
        $usuarios = User::all();
        return view('proyecto.create', compact('usuarios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'user_id' => 'required|exists:users,id',
        ]);

        Proyecto::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'user_id' => $request->user_id,
        ]);

        return redirect()->route('proyectos.index')->with('success', 'Proyecto creado correctamente.');
    }

    public function edit($id)
    {
        if (!in_array('update', json_decode(auth()->user()->proyectos_permissions, true) ?? [])) {
            abort(403, 'No tienes permiso para crear proyectos.');
        }
        $proyecto = Proyecto::findOrFail($id);
        return view('proyecto.edit', compact('proyecto'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        $proyecto = Proyecto::findOrFail($id);
        $proyecto->update([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
        ]);

        return redirect()->route('proyectos.index')->with('success', 'Proyecto actualizado correctamente.');
    }

    public function destroy($id)
    {
        $proyecto = Proyecto::findOrFail($id);
        $proyecto->delete();

        return redirect()->route('proyectos.index')->with('success', 'Proyecto eliminado correctamente.');
    }

    public function buscar(Request $request)
    {
        $nombre = $request->input('nombre');
        $proyectos = Proyecto::where('nombre', 'like', '%' . $nombre . '%')->get();
        return view('proyecto.index', compact('proyectos'));
    }

}
