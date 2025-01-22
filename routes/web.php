<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;

Route::get('/', function () {
    $people = ['Alex', 'Mariana', 'Froy', 'Hugo',];
    return view('index', compact('people'));
});

Route::get('/menu/{person}/{section}', function ($person, $section) {
    return view('section', compact('person', 'section'));
})->name('menu.section');
