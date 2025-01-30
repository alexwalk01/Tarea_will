<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use Illuminate\Support\Facades\Auth;

Auth::routes();
Route::get('/', function(){
    return
redirect()->route('login');
});
Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');

Route::get('/menu/{name}/{section}', [MenuController::class, 'section'])->name('menu.section');




Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');

Route::middleware(['auth'])->group(function () {
Route::get('/menu/{name}/{section}', [MenuController::class, 'section'])->name('menu.section');
    Route::get('/home', function () {
        return redirect()->route('menu.index');
    })->name('home');
});


Route::post('/logout', function () {
    Auth::logout();
    return response()->json(['message' => 'Logout successful']);
});


Route::get('/test_error', function () {
    abort(500);
});