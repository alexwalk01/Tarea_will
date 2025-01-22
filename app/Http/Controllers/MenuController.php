<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        $people = ['Ana', 'Carlos', 'Maria', 'Luis', 'Sofia'];
        return view('menu.index', compact('people'));
    }

    public function section($name, $section)
    {
        $sections = ['juegos', 'proyectos', 'materias'];
        if (!in_array($section, $sections)) {
            abort(404);
        }
        return view('menu.section', compact('name', 'section'));
    }
}
