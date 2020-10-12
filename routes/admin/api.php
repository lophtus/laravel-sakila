<?php

use Illuminate\Support\Facades\Route;

 /**
 * @OA\Server(
 *   url="http://admin.{domain}/api",
 *   description="Api v1",
 *   @OA\ServerVariable(
 *     serverVariable="domain",
 *     default=APP_DOMAIN
 *   )
 * )
 */

Route::domain('admin.' . config('app.domain'))
    ->group(function () {
        require base_path('routes/admin/api/actors.php');
        require base_path('routes/admin/api/categories.php');
        require base_path('routes/admin/api/customers.php');
        require base_path('routes/admin/api/films.php');
        require base_path('routes/admin/api/inventory.php');
        require base_path('routes/admin/api/payments.php');
        require base_path('routes/admin/api/rentals.php');
        require base_path('routes/admin/api/staffs.php');
        require base_path('routes/admin/api/stores.php');
    });
