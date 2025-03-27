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
use App\Http\Middleware\CheckPermissions;
use App\Http\Middleware\CheckTokenExpiration;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Route;

// Rutas de autenticación
Auth::routes();

// Ruta principal, redirige al login si no está autenticado
Route::get('/', function () {
    return redirect()->route('login');
})->name('home');

// Ruta de login
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::post('/login', [LoginController::class, 'login']);

// Rutas protegidas por autenticación
Route::middleware(['auth', CheckTokenExpiration::class])->group(function () {
    // Rutas del menú principal
    Route::get('/home', [MenuController::class, 'index'])->name('home');
    Route::get('/menu/{name}/{section}', [MenuController::class, 'section'])->name('menu.section');
    Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');

    Route::middleware(CheckPermissions::class . ':materias_permissions')->group(function () {
        Route::get('/materias', [MateriaController::class, 'index'])->name('materias.index');
        Route::get('/materia/{id}', [MateriaController::class, 'show'])->name('materia.show');
        Route::get('/materia/{id}/descripcion', [MateriaController::class, 'descripcion'])->name('materia.descripcion');
        Route::resource('materias', MateriaController::class);
    });

    Route::middleware(CheckPermissions::class . ':juegos_permissions')->group(function () {
        Route::get('/juegos', [JuegoController::class, 'index'])->name('juegos.index');
        Route::get('/juego/{id}', [JuegoController::class, 'show'])->name('juego.show');
        Route::get('/juego/{id}/descripcion', [JuegoController::class, 'descripcion'])->name('juego.descripcion');
        Route::resource('juegos', JuegoController::class);
    });

    Route::middleware(CheckPermissions::class . ':proyectos_permissions')->group(function () {
        Route::get('/proyectos', [ProyectoController::class, 'index'])->name('proyectos.index');
        Route::get('/proyecto/{id}', [ProyectoController::class, 'show'])->name('proyecto.show');
        Route::get('/proyecto/{id}/descripcion', [ProyectoController::class, 'descripcion'])->name('proyecto.descripcion');
        Route::resource('proyectos', ProyectoController::class);
    });

    // Rutas de búsqueda
    Route::get('/buscar', [BusquedaController::class, 'buscar'])->name('buscar.general');

    // Rutas de carga adicional (paginación o carga infinita)
    Route::get('/cargar-todos-los-juegos', [JuegoController::class, 'cargarTodosLosJuegos']);
    Route::get('/cargar-todas-las-materias', [MateriaController::class, 'cargarTodasLasMaterias']);
    Route::get('/cargar-todos-los-proyectos', [ProyectoController::class, 'cargarTodosLosProyectos']);
    Route::get('/cargar-mas-juegos', [JuegoController::class, 'cargarMasJuegos']);
    Route::get('/cargar-mas-materias', [MateriaController::class, 'cargarMasMaterias'])->name('materias.cargarMas');

    // Rutas de administración (solo para usuarios con permisos de administrador)
    Route::prefix('admin')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('admin.index');
        Route::post('/update-permissions/{userId}', [AdminController::class, 'updateUserPermissions'])->name('admin.updatePermissions');
        Route::get('/admin/register', [AdminController::class, 'showAdminRegisterForm'])->name('admin.register');
        Route::post('/admin/register', [AdminController::class, 'registerAdmin']);
        Route::resource('proyectos', ProyectoController::class);
        Route::resource('juegos', JuegoController::class);
        Route::resource('materias', MateriaController::class);
        Route::delete('/admin/users/{userId}', [AdminController::class, 'deleteUser'])->name('admin.deleteUser');
        // Juegos
        Route::get('/juegos/create', [AdminController::class, 'createJuego'])->name('juegos.create');
        Route::post('/juegos', [AdminController::class, 'storeJuego'])->name('juegos.store');
        Route::get('/juegos/{id}', [AdminController::class, 'showJuego'])->name('juegos.show');
        Route::get('/juegos/{id}/edit', [AdminController::class, 'editJuego'])->name('juegos.edit');
        Route::put('/juegos/{id}', [AdminController::class, 'updateJuego'])->name('juegos.update');
        Route::delete('/juegos/{id}', [AdminController::class, 'destroyJuego'])->name('juegos.destroy');
        Route::delete('/juegos/{id}', [AdminController::class, 'destroyJuego'])->name('juegos.destroy');
        Route::put('/juegos/{id}', [AdminController::class, 'updateJuego'])->name('juegos.update');

        // Materias
        Route::get('/materias/create', [AdminController::class, 'createMateria'])->name('materias.create');
        Route::post('/materias', [AdminController::class, 'storeMateria'])->name('materias.store');
        Route::get('/materias/{id}', [AdminController::class, 'showMateria'])->name('materias.show');
        Route::get('/materias/{id}/edit', [AdminController::class, 'editMateria'])->name('materias.edit');
        Route::put('/materias/{id}', [AdminController::class, 'updateMateria'])->name('materias.update');
        Route::delete('/materias/{id}', [AdminController::class, 'destroyMateria'])->name('materias.destroy');

        // Proyectos
        Route::get('/proyectos/create', [AdminController::class, 'createProyecto'])->name('proyectos.create');
        Route::post('/proyectos', [AdminController::class, 'storeProyecto'])->name('proyectos.store');
        Route::get('/proyectos/{id}', [AdminController::class, 'showProyecto'])->name('proyectos.show');
        Route::get('/proyectos/{id}/edit', [AdminController::class, 'editProyecto'])->name('proyectos.edit');
        Route::put('/proyectos/{id}', [AdminController::class, 'updateProyecto'])->name('proyectos.update');
        Route::delete('/proyectos/{id}', [AdminController::class, 'destroyProyecto'])->name('proyectos.destroy');
    });
});

// Rutas de seguridad (recuperación de contraseña, etc.)
Route::get('/password/security', [SecurityController::class, 'showForm'])->name('security.form');
Route::post('/password/security', [SecurityController::class, 'verifyAnswers'])->name('security.verify');
Route::post('/password/security/update', [SecurityController::class, 'updatePassword'])->name('security.update');

// Rutas de SMS
Route::get('/sms/form', [SmsController::class, 'index'])->name('sms.form');
Route::post('/sms/send', [SmsController::class, 'sendSms'])->name('sms.send');
Route::get('/sms/verify', [SmsController::class, 'showVerificationForm'])->name('sms.verify');
Route::post('/sms/verify-code', [SmsController::class, 'verifyCode'])->name('sms.verify_code');

// Ruta para verificación de correo electrónico
Route::get('/verify/{verificationCode}', [LoginController::class, 'verify'])->name('verify.email');

// Ruta para recuperación de contraseña
Route::get('/password/recovery', function () {
    return view('auth.password_recovery');
})->name('password.recovery');

// Ruta para token expirado
Route::get('/token-expired', function () {
    return view('auth.login');
})->name('token.expired');

// Rutas de broadcasting (canales)
Broadcast::channel('user.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
