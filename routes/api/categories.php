<?php

use App\Http\Controllers\Api\CategoryController;
use Illuminate\Support\Facades\Route;

/**
 * @OA\Get(
 *   description="Retrieve a list of categories",
 *   path="/categories",
 *   tags={"categories"},
 *   @OA\Parameter(
 *     description="Filter by name",
 *     name="filter[name]",
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
 *   @OA\Parameter(ref="#/components/parameters/IncludeableInclude"),
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
