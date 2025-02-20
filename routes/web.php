<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\JuegoController;
use App\Http\Controllers\MateriaController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ProyectoController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BusquedaController;

Auth::routes();

// Ruta principal, redirige al login
Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/cargar-mas-juegos', [JuegoController::class, 'cargarMasJuegos']);

Route::get('/cargar-mas-materias', [MateriaController::class, 'cargarMasMaterias'])->name('materias.cargarMas');

// web.php
Route::get('/buscar', [BusquedaController::class, 'buscar'])->name('buscar.general');

// Rutas para el menú principal
Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');

// Ruta para los juegos, materias y proyectos
Route::middleware(['auth'])->group(function () {
    Route::get('/home', function () {
        return redirect()->route('menu.index');
    })->name('home');

    Route::get('/menu/{name}/{section}', [MenuController::class, 'section'])->name('menu.section');

    // Rutas para materias, juegos y proyectos
    Route::get('/materias', [MateriaController::class, 'index'])->name('materia.index');
    Route::get('/materia/{id}', [MateriaController::class, 'show'])->name('materia.show');
    Route::get('/juegos', [JuegoController::class, 'index'])->name('juego.index');
    Route::get('/juego/{id}', [JuegoController::class, 'show'])->name('juego.show');
    Route::get('/proyectos', [ProyectoController::class, 'index'])->name('proyecto.index');
    Route::get('/proyecto/{id}', [ProyectoController::class, 'show'])->name('proyecto.show');
});

// Ruta para descripción de materia, juegos y proyectos
Route::get('/juego/{id}/descripcion', [JuegoController::class, 'descripcion'])->name('juego.descripcion');
Route::get('/proyecto/{id}/descripcion', [ProyectoController::class, 'descripcion'])->name('proyecto.descripcion');
Route::get('/materia/{id}/descripcion', [MateriaController::class, 'descripcion'])->name('materia.descripcion');

Route::prefix('admin')->middleware('auth')->group(function() {
    Route::get('/', [AdminController::class, 'index'])->name('admin.index');
    Route::resource('juegos', JuegoController::class);
    Route::resource('materias', MateriaController::class);
    Route::resource('proyectos', ProyectoController::class);
});

