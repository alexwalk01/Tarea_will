<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        // Lista de personas
        $people = ['Alex', 'Mariana', 'Froy', 'Hugo'];
        return view('menu.index', compact('people'));
    }

    public function section($name, $section)
    {
        // Verifica que la sección solicitada sea válida
        $sections = ['juegos', 'proyectos', 'materias'];
        if (!in_array($section, $sections)) {
            abort(404);  // Llama a la página 404 si la sección no existe
        }

        return view('menu.section', compact('name', 'section'));
    }

    public function show($person, $category, $subcategory)
    {
        // Lógica para obtener los datos basados en la persona, categoría y subcategoría
        return view('menu.show', compact('person', 'category', 'subcategory'));
    }
}
