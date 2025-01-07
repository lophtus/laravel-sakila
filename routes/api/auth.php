<?php

/** Auth route definitions */

use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;

/**
 * @OA\Post(
 *   description="Authenticate a user",
 *   path="/login",
 *   tags={"auth"},
 *   @OA\RequestBody(
 *     description="An object containing information about a auth",
 *     @OA\JsonContent(ref="#/components/schemas/AuthRequest"),
 *   ),
 *   @OA\Response(
 *     response="201",
 *     description="The object was created successfully",
 *     @OA\JsonContent(ref="#/components/schemas/AuthResource"),
 *   ),
 *   @OA\Response(
 *     response="422",
 *     ref="#/components/responses/ValidationErrorResponse",
 *   ),
 * )
 */
Route::post('/login', AuthController::class . '@login');
