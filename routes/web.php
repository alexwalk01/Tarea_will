<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;

Route::get('/', [MenuController::class, 'index'])->name('menu.index');
Route::get('/person/{name}/{section}', [MenuController::class, 'section'])->name('menu.section');

