<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use Illuminate\Support\Facades\Auth;

// Redirigir al login en el dominio raíz
Route::get('/', function () {
    return redirect()->route('login');
});

// Rutas del menú (perfil, materias, juego, proyecto, etc.)
Route::get('/menu/{person}/{section}', function ($person, $section) {
    return view('section', compact('person', 'section'));
})->name('menu.section');

// Ruta para mostrar el índice de personas (ej. Alex, Mariana, etc.)
Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');

// Ruta para el perfil de una persona
Route::get('/person/{name}/{section}', [MenuController::class, 'section'])->name('menu.section');

// Rutas de autenticación
Auth::routes();

// Ruta protegida para el inicio (home), solo accesible si el usuario está autenticado
Route::middleware(['auth'])->group(function () {
    Route::get('/home', function () {
        $people = ['Alex', 'Mariana', 'Froy', 'Hugo'];
        return view('index', compact('people'));
    });
});

// Ruta para cerrar sesión
Route::post('/logout', function () {
    Auth::logout();
    return response()->json(['message' => 'Logout successful']);
});
