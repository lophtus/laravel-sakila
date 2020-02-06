<?php

use Illuminate\Support\Facades\Route;

/**
 * @OA\Get(
 *   description="Retrieve a list of stores",
 *   path="/stores",
 *   tags={"stores"},
 *   @OA\Parameter(ref="#/components/parameters/PageablePageNumber"),
 *   @OA\Parameter(ref="#/components/parameters/PageablePageSize"),
 *   @OA\Response(
 *     response="200",
 *     description="A collection of objects containing information about stores",
 *     @OA\JsonContent(ref="#/components/schemas/StoreCollection"),
 *   ),
 * )
 */
Route::get('/stores', 'Api\\StoreController@index');

/**
 * @OA\Get(
 *   description="Retrieve the specified store",
 *   path="/stores/{id}",
 *   tags={"stores"},
 *   @OA\Parameter(
 *     name="id",
 *     description="A unique identifier for a store",
 *     in="path",
 *   ),
 *   @OA\Response(
 *     response="200",
 *     description="An object containing information for a store",
 *     @OA\JsonContent(ref="#/components/schemas/StoreResource"),
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
Route::get('/stores/{id}', 'Api\\StoreController@show');

/**
 * @OA\Post(
 *   description="Create a new store for the specified store",
 *   path="/stores",
 *   tags={"stores"},
 *   @OA\RequestBody(
 *     description="An object containing information about a store",
 *     @OA\JsonContent(ref="#/components/schemas/StoreStoreRequest"),
 *   ),
 *   @OA\Response(
 *     response="201",
 *     description="The object was created successfully",
 *     @OA\JsonContent(ref="#/components/schemas/StoreResource"),
 *   ),
 *   @OA\Response(
 *     response="422",
 *     ref="#/components/responses/ValidationErrorResponse",
 *   ),
 * )
 */
Route::post('/stores', 'Api\\StoreController@store');

/**
 * @OA\Patch(
 *   description="Update the specified store",
 *   path="/stores/{id}",
 *   tags={"stores"},
 *   @OA\Parameter(
 *     name="id",
 *     description="A unique identifier for a store",
 *     in="path",
 *   ),
 *   @OA\RequestBody(
 *     description="An object containing information about a store",
 *     @OA\JsonContent(ref="#/components/schemas/UpdateStoreRequest"),
 *   ),
 *   @OA\Response(
 *     response="204",
 *     description="The store was updated successfully",
 *   ),
 *   @OA\Response(
 *     response="404",
 *     ref="#/components/responses/NotFoundResponse",
 *   ),
 *   @OA\Response(
 *     response="422",
 *     ref="#/components/responses/ValidationErrorResponse",
 *   ),
 *   @OA\Response(
 *     response="500",
 *     ref="#/components/responses/ServerErrorResponse",
 *   ),
 * )
 */
Route::patch('/stores/{id}', 'Api\\StoreController@update');

/**
 * @OA\Delete(
 *   description="Delete the specified store",
 *   path="/stores/{id}",
 *   tags={"stores"},
 *   @OA\Parameter(
 *     name="id",
 *     description="A unique identifier for a store",
 *     in="path",
 *   ),
 *   @OA\Response(
 *     response="200",
 *     description="The store was deleted successfully",
 *     @OA\JsonContent(ref="#/components/schemas/StoreResource"),
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
Route::delete('/stores/{id}', 'Api\\StoreController@destroy');
