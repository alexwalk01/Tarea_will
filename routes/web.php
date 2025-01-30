<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\JuegoController;
use App\Http\Controllers\MateriaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ProyectoController;
use Illuminate\Support\Facades\Auth;

Auth::routes();

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');

Route::middleware(['auth'])->group(function () {
    Route::get('/home', function () {
        return redirect()->route('menu.index');
    })->name('home');

    Route::get('/menu/{name}/{section}', [MenuController::class, 'section'])->name('menu.section');
});

// Rutas para juegos, materias y proyectos
Route::get('/materias', [MateriaController::class, 'index'])->name('materia.index');
Route::get('/materia/{id}', [MateriaController::class, 'show'])->name('materia.show'); // Usar show aquí
Route::get('/juegos', [JuegoController::class, 'index'])->name('juego.index');
Route::get('/proyectos', [ProyectoController::class, 'index'])->name('proyecto.index');
Route::get('/proyecto/{id}', [ProyectoController::class, 'show'])->name('proyecto.show');

// Ruta de descripción de juego (por si la necesitas)
Route::get('/juego/{id}/descripcion', [JuegoController::class, 'descripcion'])->name('juego.descripcion');
Route::get('/proyecto/{id}/descripcion', [ProyectoController::class, 'descripcion'])->name('proyecto.descripcion');
Route::get('/materia/{id}/descripcion', [MateriaController::class, 'descripcion'])->name('materia.descripcion');
