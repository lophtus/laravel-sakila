<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * This namespace is applied to your admin controller routes.
     *
     * @var string
     */
    protected $adminNamespace = 'App\Http\Controllers\Admin';

    /**
     * The path to the "home" route for your application.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapAdminApiRoutes();

        $this->mapAdminWebRoutes();

        $this->mapApiRoutes();

        $this->mapWebRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::name('web')
            ->middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));
    }

    /**
     * Define the "web" routes for the admin application
     *
     * @return void
     */
    protected function mapAdminWebRoutes()
    {
        Route::name('admin-web')
             ->domain('admin.' . config('app.domain'))
             ->middleware('web')
             ->namespace($this->adminNamespace)
             ->group(base_path('routes/admin/web.php'));
    }

    /**
     * Define the "api" routes for the admin application
     *
     * @return void
     */
    protected function mapAdminApiRoutes()
    {
        Route::name('admin-api')
             ->prefix('api')
             ->middleware('api')
             ->namespace($this->adminNamespace)
             ->group(base_path('routes/admin/api.php'));
    }
}
