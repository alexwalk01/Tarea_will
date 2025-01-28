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

        // Si la sección no existe, lanza un error 404
        if (!in_array($section, $sections)) {
            abort(404); // Error 404: Página no encontrada
        }

        // Ejemplo: lógica para restringir acceso a ciertas personas o secciones
        $restrictedSections = ['proyectos']; // Secciones restringidas
        if (in_array($section, $restrictedSections) && $name !== 'Admin') {
            abort(403); // Error 403: Acceso prohibido
        }

        return view('menu.section', compact('name', 'section'));
    }

    public function show($person, $category, $subcategory)
    {
        // Lógica para obtener los datos basados en la persona, categoría y subcategoría
        return view('menu.show', compact('person', 'category', 'subcategory'));
    }
}
