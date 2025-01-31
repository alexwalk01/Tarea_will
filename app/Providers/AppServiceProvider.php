<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Juego;
use App\Models\Materia;
use App\Models\Proyecto;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        View::composer('*', function ($view) {
            if (Auth::check()) {
                $juegos = Auth::user()->juegos;
                $materias = Auth::user()->materias;
                $proyectos = Auth::user()->proyectos;

                $view->with(compact('juegos', 'materias', 'proyectos'));
            }
        });
    }
}
