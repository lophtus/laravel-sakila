<?php

use Illuminate\Support\Facades\Route;

/**
 * @OA\Get(
 *   description="Retrieve a list of rentals",
 *   path="/rentals",
 *   tags={"rentals"},
 *   @OA\Parameter(ref="#/components/parameters/PageablePageNumber"),
 *   @OA\Parameter(ref="#/components/parameters/PageablePageSize"),
 *   @OA\Response(
 *     response="200",
 *     description="A collection of objects containing information about rentals",
 *     @OA\JsonContent(ref="#/components/schemas/RentalCollection"),
 *   ),
 * )
 */
Route::get('/rentals', 'Api\\RentalController@index');

/**
 * @OA\Get(
 *   description="Retrieve a list of rentals by customer",
 *   path="/customers/{id}/rentals",
 *   tags={"rentals", "customers"},
 *   @OA\Parameter(
 *     name="id",
 *     description="A unique identifier for a customer",
 *     in="path",
 *   ),
 *   @OA\Parameter(ref="#/components/parameters/PageablePageNumber"),
 *   @OA\Parameter(ref="#/components/parameters/PageablePageSize"),
 *   @OA\Response(
 *     response="200",
 *     description="A collection of objects containing information about rentals",
 *     @OA\JsonContent(ref="#/components/schemas/RentalCollection"),
 *   ),
 * )
 */
Route::get('/customers/{customer}/rentals', 'Api\\RentalController@indexByCustomer');

/**
 * @OA\Get(
 *   description="Retrieve a list of rentals by store",
 *   path="/stores/{id}/rentals",
 *   tags={"rentals", "stores"},
 *   @OA\Parameter(
 *     name="id",
 *     description="A unique identifier for a store",
 *     in="path",
 *   ),
 *   @OA\Parameter(ref="#/components/parameters/PageablePageNumber"),
 *   @OA\Parameter(ref="#/components/parameters/PageablePageSize"),
 *   @OA\Response(
 *     response="200",
 *     description="A collection of objects containing information about rentals",
 *     @OA\JsonContent(ref="#/components/schemas/RentalCollection"),
 *   ),
 * )
 */
Route::get('/stores/{store}/rentals', 'Api\\RentalController@indexByStore');

/**
 * @OA\Get(
 *   description="Retrieve the specified rental",
 *   path="/rentals/{id}",
 *   tags={"rentals"},
 *   @OA\Parameter(
 *     name="id",
 *     description="A unique identifier for a rental",
 *     in="path",
 *   ),
 *   @OA\Response(
 *     response="200",
 *     description="An object containing information for a rental",
 *     @OA\JsonContent(ref="#/components/schemas/RentalResource"),
 *   ),
 *   @OA\Response(
 *     response="404",
 *     ref="#/components/responses/NotFoundResponse",
 *   ),
 *   @OA\Response(
 *     response="500",
 *     ref="#/components/responses/ServerErrorResponse",
 *   ),
 * )
 */
Route::get('/rentals/{id}', 'Api\\RentalController@show');

/**
 * @OA\Delete(
 *   description="Delete the specified rental",
 *   path="/rentals/{id}",
 *   tags={"rentals"},
 *   @OA\Parameter(
 *     name="id",
 *     description="A unique identifier for a rental",
 *     in="path",
 *   ),
 *   @OA\Response(
 *     response="200",
 *     description="The rental was deleted successfully",
 *     @OA\JsonContent(ref="#/components/schemas/RentalResource"),
 *   ),
 *   @OA\Response(
 *     response="404",
 *     ref="#/components/responses/NotFoundResponse",
 *   ),
 *   @OA\Response(
 *     response="500",
 *     ref="#/components/responses/ServerErrorResponse",
 *   ),
 * )
 */
Route::delete('/rentals/{id}', 'Api\\RentalController@destroy');
