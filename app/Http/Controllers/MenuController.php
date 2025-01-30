<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Juego;
use App\Models\Materia;
use App\Models\Proyecto;

class MenuController extends Controller {
    public function index() {
        $user = Auth::user();
        return view('index', compact('user'));
    }

    public function section($name, $section) {
        if (Auth::user()->name !== ucfirst($name)) {
            abort(403);
        }

        $validSections = ['juegos', 'materias', 'proyectos'];
        if (!in_array($section, $validSections)) {
            abort(404);
        }

        $data = match ($section) {
            'juegos' => Auth::user()->juegos,
            'materias' => Auth::user()->materias,
            'proyectos' => Auth::user()->proyectos,
        };

        return view("{$name}.{$section}.principal", compact('name', 'section', 'data'));
    }
}
