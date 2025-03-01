<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\JuegoController;
use App\Http\Controllers\MateriaController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ProyectoController;
use App\Http\Controllers\BusquedaController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\SmsController;

Auth::routes();
//hola
// Ruta principal, redirige al login si no está autenticado
Route::get('/', function () {
    return redirect()->route('login');
});

// Ruta pública
Route::get('/publico', function () {
    return view('publico');
})->name('publico');


// Grupo de rutas protegidas por autenticación
Route::middleware(['auth'])->group(function () {
    Route::get('/home', function () {
        return redirect()->route('menu.index');
    })->name('home');

    // Rutas protegidas para el menú
    Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');
    Route::get('/menu/{name}/{section}', [MenuController::class, 'section'])->name('menu.section');

    // Rutas protegidas para materias, juegos y proyectos
    Route::get('/materias', [MateriaController::class, 'index'])->name('materia.index');
    Route::get('/materia/{id}', [MateriaController::class, 'show'])->name('materia.show');
    Route::get('/juegos', [JuegoController::class, 'index'])->name('juego.index');
    Route::get('/juego/{id}', [JuegoController::class, 'show'])->name('juego.show');
    Route::get('/proyectos', [ProyectoController::class, 'index'])->name('proyecto.index');
    Route::get('/proyecto/{id}', [ProyectoController::class, 'show'])->name('proyecto.show');

    // Rutas de descripción (también protegidas)
    Route::get('/juego/{id}/descripcion', [JuegoController::class, 'descripcion'])->name('juego.descripcion');
    Route::get('/proyecto/{id}/descripcion', [ProyectoController::class, 'descripcion'])->name('proyecto.descripcion');
    Route::get('/materia/{id}/descripcion', [MateriaController::class, 'descripcion'])->name('materia.descripcion');

    // Rutas de administración protegidas
    Route::prefix('admin')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('admin.index');
        Route::resource('juegos', JuegoController::class);
        Route::resource('materias', MateriaController::class);
        Route::resource('proyectos', ProyectoController::class);
    });
    // Rutas accesibles sin autenticación
    Route::get('/cargar-todos-los-juegos', [JuegoController::class, 'cargarTodosLosJuegos']);
    Route::get('/cargar-todas-las-materias', [MateriaController::class, 'cargarTodasLasMaterias']);
    Route::get('/cargar-todos-los-proyectos', [ProyectoController::class, 'cargarTodosLosProyectos']);
    Route::get('/cargar-mas-juegos', [JuegoController::class, 'cargarMasJuegos']);
    Route::get('/cargar-mas-materias', [MateriaController::class, 'cargarMasMaterias'])->name('materias.cargarMas');
    Route::get('/buscar', [BusquedaController::class, 'buscar'])->name('buscar.general');
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

Route::get('/sms/form', [SmsController::class, 'index'])->name('sms.form');
Route::post('/sms/send', [SmsController::class, 'sendSms'])->name('sms.send');
Route::get('/sms/verify', [SmsController::class, 'showVerificationForm'])->name('sms.verify'); // Asegúrate de que sea un GET
Route::post('/sms/verify', [SmsController::class, 'verifyCode'])->name('sms.verify.code'); // Cambia el nombre para diferenciar

Route::get('/password/recovery', function () {
    return view('auth.password_recovery');
})->name('password.recovery');

Route::post('/password/update', [App\Http\Controllers\Auth\ResetPasswordController::class, 'updatePassword'])
    ->name('password.update');
