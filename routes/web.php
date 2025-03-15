<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\JuegoController;
use App\Http\Controllers\MateriaController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ProyectoController;
use App\Http\Controllers\BusquedaController;
use App\Http\Controllers\SmsController;
use App\Http\Controllers\Auth\SecurityController;
use App\Http\Middleware\CheckTokenExpiration;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();
// Ruta principal, redirige al login si no está autenticado
Route::get('/', function () {
    return redirect()->route('login');
});


Route::get('/login', function () {
    return view('auth.login'); // Aquí debes tener tu vista de login
})->name('login');

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::post('/login', [LoginController::class, 'login']);


Route::middleware(['auth', CheckTokenExpiration::class])->group(function () {
    Route::get('/home', [MenuController::class, 'index'])->name('home');
    Route::get('/menu/{name}/{section}', [MenuController::class, 'section'])->name('menu.section');
    Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');
    Route::get('/materias', [MateriaController::class, 'index'])->name('materia.index');
    Route::get('/materia/{id}', [MateriaController::class, 'show'])->name('materia.show');
    Route::get('/juegos', [JuegoController::class, 'index'])->name('juego.index');
    Route::get('/juego/{id}', [JuegoController::class, 'show'])->name('juego.show');
    Route::get('/proyectos', [ProyectoController::class, 'index'])->name('proyecto.index');
    Route::get('/proyecto/{id}', [ProyectoController::class, 'show'])->name('proyecto.show');

    // Rutas de descripción protegidas
    Route::get('/juego/{id}/descripcion', [JuegoController::class, 'descripcion'])->name('juego.descripcion');
    Route::get('/proyecto/{id}/descripcion', [ProyectoController::class, 'descripcion'])->name('proyecto.descripcion');
    Route::get('/materia/{id}/descripcion', [MateriaController::class, 'descripcion'])->name('materia.descripcion');

    // Rutas de administración protegidas
    Route::prefix('admin')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('admin.index');
        Route::resource('juegos', JuegoController::class);
        Route::resource('materias', MateriaController::class);
        Route::resource('proyectos', ProyectoController::class);
    });
    // Rutas accesibles sin autenticación
    Route::get('/cargar-todos-los-juegos', [JuegoController::class, 'cargarTodosLosJuegos']);
    Route::get('/cargar-todas-las-materias', [MateriaController::class, 'cargarTodasLasMaterias']);
    Route::get('/cargar-todos-los-proyectos', [ProyectoController::class, 'cargarTodosLosProyectos']);
    Route::get('/cargar-mas-juegos', [JuegoController::class, 'cargarMasJuegos']);
    Route::get('/cargar-mas-materias', [MateriaController::class, 'cargarMasMaterias'])->name('materias.cargarMas');
    Route::get('/buscar', [BusquedaController::class, 'buscar'])->name('buscar.general');
});
// Rutas de seguridad
Route::get('/password/security', [SecurityController::class, 'showForm'])->name('security.form');
Route::post('/password/security', [SecurityController::class, 'verifyAnswers'])->name('security.verify');
Route::post('/password/security/update', [SecurityController::class, 'updatePassword'])->name('security.update');

// Rutas de SMS
Route::get('/sms/form', [SmsController::class, 'index'])->name('sms.form');
Route::post('/sms/send', [SmsController::class, 'sendSms'])->name('sms.send');
Route::get('/sms/verify', [SmsController::class, 'showVerificationForm'])->name('sms.verify');
Route::post('/sms/verify-code', [SmsController::class, 'verifyCode'])->name('sms.verify_code');

// Ruta para recuperación de contraseña
Route::get('/password/recovery', function () {
    return view('auth.password_recovery');
})->name('password.recovery');

Route::post('/password/update', [App\Http\Controllers\Auth\ResetPasswordController::class, 'updatePassword'])
    ->name('password.update');


Route::get('/token-expired', function () {
    return view('auth.login');
})->name('token.expired');
