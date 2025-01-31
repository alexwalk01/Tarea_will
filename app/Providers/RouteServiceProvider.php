<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;

class RouteServiceProvider extends ServiceProvider
{
    public const HOME = '/';

    public function boot()
    {
        // Aquí Laravel define las rutas sin el método routes()
        $this->mapWebRoutes();
        $this->mapApiRoutes();
    }

    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->group(base_path('routes/web.php'));
    }

    protected function mapApiRoutes()
    {
        Route::middleware('api')
            ->prefix('api')
            ->group(base_path('routes/api.php'));
    }
}
