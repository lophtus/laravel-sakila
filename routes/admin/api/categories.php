<?php

/** Category route definitions */

use App\Http\Controllers\Admin\Api\CategoryController;
use Illuminate\Support\Facades\Route;

/**
 * @OA\Get(
 *   description="Retrieve a list of categories",
 *   path="/categories",
 *   tags={"categories"},
 *   @OA\Parameter(
 *     description="Filter by name",
 *     name="filter[search]",
 *     in="query",
 *     @OA\Schema(
 *       type="string",
 *     )
 *   ),
 *   @OA\Parameter(ref="#/components/parameters/PageablePageNumber"),
 *   @OA\Parameter(ref="#/components/parameters/PageablePageSize"),
 *   @OA\Response(
 *     response="200",
 *     description="A collection of objects containing information about categories",
 *     @OA\JsonContent(ref="#/components/schemas/CategoryCollection"),
 *   ),
 * )
 */
Route::get('/categories', CategoryController::class . '@index');

/**
 * @OA\Get(
 *   description="Retrieve the specified category",
 *   path="/categories/{id}",
 *   tags={"categories"},
 *   @OA\Parameter(
 *     name="id",
 *     description="A unique identifier for a category",
 *     in="path",
 *   ),
 *   @OA\Response(
 *     response="200",
 *     description="An object containing information for a category",
 *     @OA\JsonContent(ref="#/components/schemas/CategoryResource"),
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
Route::get('/categories/{id}', CategoryController::class . '@show');

/**
 * @OA\Post(
 *   description="Create a new category",
 *   path="/categories",
 *   tags={"categories"},
 *   @OA\RequestBody(
 *     description="An object containing information about a category",
 *     @OA\JsonContent(ref="#/components/schemas/StoreCategoryRequest"),
 *   ),
 *   @OA\Response(
 *     response="201",
 *     description="The object was created successfully",
 *     @OA\JsonContent(ref="#/components/schemas/CategoryResource"),
 *   ),
 *   @OA\Response(
 *     response="422",
 *     ref="#/components/responses/ValidationErrorResponse",
 *   ),
 * )
 */
Route::post('/categories', CategoryController::class . '@store');

/**
 * @OA\Patch(
 *   description="Update the specified category",
 *   path="/categories/{id}",
 *   tags={"categories"},
 *   @OA\Parameter(
 *     name="id",
 *     description="A unique identifier for a category",
 *     in="path",
 *   ),
 *   @OA\RequestBody(
 *     description="An object containing information about a category",
 *     @OA\JsonContent(ref="#/components/schemas/UpdateCategoryRequest"),
 *   ),
 *   @OA\Response(
 *     response="204",
 *     description="The category was updated successfully",
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
Route::patch('/categories/{id}', CategoryController::class . '@update');

/**
 * @OA\Delete(
 *   description="Delete the specified category",
 *   path="/categories/{id}",
 *   tags={"categories"},
 *   @OA\Parameter(
 *     name="id",
 *     description="A unique identifier for a category",
 *     in="path",
 *   ),
 *   @OA\Response(
 *     response="200",
 *     description="The category was deleted successfully",
 *     @OA\JsonContent(ref="#/components/schemas/CategoryResource"),
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
Route::delete('/categories/{id}', CategoryController::class . '@destroy');
