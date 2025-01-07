<?php

/** Api route definitions */

use Illuminate\Support\Facades\Route;

 /**
 * @OA\Server(
 *   url="http://{domain}/api",
 *   description="Api v1",
 *   @OA\ServerVariable(
 *     serverVariable="domain",
 *     default=APP_DOMAIN
 *   )
 * )
 */

Route::name('api')
    ->group(function ($router) {
        require base_path('routes/api/auth.php');

        $router->middleware('auth:api')
            ->group(function () {
                require base_path('routes/api/categories.php');
                require base_path('routes/api/customer.php');
                require base_path('routes/api/films.php');
                require base_path('routes/api/rentals.php');
            });
    });
