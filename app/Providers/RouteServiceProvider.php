<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Auth\Middleware\RedirectIfAuthenticated;

class RouteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Web routes
        Route::middleware('web')
            ->group(base_path('routes/web.php'));

        // API routes
        Route::middleware('api')
            ->prefix('api')
            ->group(base_path('routes/api.php'));

        // Override guest redirect
        RedirectIfAuthenticated::redirectUsing(function ($request) {
            if (auth('auth')->check()) {
                return route('Dashboard');
            }

            return route('Dashboard');
        });
    }
}
