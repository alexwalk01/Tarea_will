<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use Illuminate\Support\Facades\Auth;



Route::get('/menu/{person}/{section}', function ($person, $section) {
    return view('section', compact('person', 'section'));
})->name('menu.section');
Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');
Route::get('/person/{name}/{section}', [MenuController::class, 'section'])->name('menu.section');

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {

    Route::get('/home', function () {
        $people = ['Alex', 'Mariana', 'Froy', 'Hugo',];
        return view('index', compact('people'));
    });
});
Route::post('/logout', function () {
    Auth::logout();
    return response()->json(['message' => 'Logout successful']);
});



Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
