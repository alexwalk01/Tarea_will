<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use Illuminate\Support\Facades\Auth;

// Ruta para el índice
Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');

// Ruta para acceder a una sección de una persona (ej. /menu/Alex/juegos)
Route::get('/menu/{name}/{section}', [MenuController::class, 'section'])->name('menu.section');

// Rutas de autenticación
Auth::routes();

// Ruta de inicio después de iniciar sesión
Route::middleware(['auth'])->group(function () {
    Route::get('/home', function () {
        $people = ['Alex', 'Mariana', 'Froy', 'Hugo'];
        return view('index', compact('people'));
    });
});

// Ruta de cierre de sesión
Route::post('/logout', function () {
    Auth::logout();
    return response()->json(['message' => 'Logout successful']);
});
