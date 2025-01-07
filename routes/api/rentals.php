<?php

/** Rentals route definitions */

use App\Http\Controllers\Api\RentalController;
use Illuminate\Support\Facades\Route;

/**
 * @OA\Post(
 *   description="Create a new rental",
 *   path="/stores/:store/films/:film/rent",
 *   tags={"rentals"},
 *   @OA\RequestBody(
 *     description="An object containing information about a rental",
 *     @OA\JsonContent(ref="#/components/schemas/StoreRentalRequest"),
 *   ),
 *   @OA\Response(
 *     response="201",
 *     description="The object was created successfully",
 *     @OA\JsonContent(ref="#/components/schemas/RentalResource"),
 *   ),
 *   @OA\Response(
 *     response="422",
 *     ref="#/components/responses/ValidationErrorResponse",
 *   ),
 * )
 */
Route::post('/stores/{store}/films/{film}/rent', RentalController::class . '@store');
