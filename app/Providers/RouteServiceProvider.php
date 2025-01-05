<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, etc.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        Route::name('admin-api')
             ->prefix('api')
             ->middleware('api')
             ->group(base_path('routes/admin/api.php'));

        Route::name('admin-web')
             ->domain('admin.' . config('app.domain'))
             ->middleware('web')
             ->group(base_path('routes/admin/web.php'));

        Route::prefix('api')
            ->middleware('api')
            ->group(base_path('routes/api.php'));

        Route::name('web')
            ->middleware('web')
            ->group(base_path('routes/web.php'));
    }
}
