<?php

/** Inventory route definitions */

use App\Http\Controllers\Admin\Api\InventoryController;
use Illuminate\Support\Facades\Route;

/**
 * @OA\Get(
 *   description="Retrieve a list of inventory",
 *   path="/inventory",
 *   tags={"inventory"},
 *   @OA\Parameter(ref="#/components/parameters/IncludeableInclude"),
 *   @OA\Parameter(ref="#/components/parameters/PageablePageNumber"),
 *   @OA\Parameter(ref="#/components/parameters/PageablePageSize"),
 *   @OA\Response(
 *     response="200",
 *     description="A collection of objects containing information about inventory",
 *     @OA\JsonContent(ref="#/components/schemas/InventoryCollection"),
 *   ),
 * )
 */
Route::get('/inventory', InventoryController::class . '@index');

/**
 * @OA\Get(
 *   description="Retrieve a list of inventory by film",
 *   path="/films/{id}/inventory",
 *   tags={"inventory"},
 *   @OA\Parameter(
 *     description="A unique identifier for a film",
 *     name="id",
 *     in="path",
 *     @OA\Schema(
 *       type="integer",
 *     ),
 *   ),
 *   @OA\Parameter(ref="#/components/parameters/IncludeableInclude"),
 *   @OA\Parameter(ref="#/components/parameters/PageablePageNumber"),
 *   @OA\Parameter(ref="#/components/parameters/PageablePageSize"),
 *   @OA\Response(
 *     response="200",
 *     description="A collection of objects containing information about inventory",
 *     @OA\JsonContent(ref="#/components/schemas/InventoryCollection"),
 *   ),
 * )
 */
Route::get('/films/{film}/inventory', InventoryController::class . '@indexByFilm');

/**
 * @OA\Get(
 *   description="Retrieve a list of inventory by store",
 *   path="/stores/{id}/inventory",
 *   tags={"inventory"},
 *   @OA\Parameter(
 *     description="A unique identifier for a store",
 *     name="id",
 *     in="path",
 *     @OA\Schema(
 *       type="integer",
 *     ),
 *   ),
 *   @OA\Parameter(
 *     description="Filter by title",
 *     name="filter[title]",
 *     in="query",
 *     @OA\Schema(
 *       type="string",
 *     )
 *   ),
 *   @OA\Parameter(
 *     description="Filter by description",
 *     name="filter[description]",
 *     in="query",
 *     @OA\Schema(
 *       type="string",
 *     )
 *   ),
 *   @OA\Parameter(
 *     description="Filter by release year",
 *     name="filter[release_year]",
 *     in="query",
 *     @OA\Schema(
 *       type="integer",
 *     )
 *   ),
 *   @OA\Parameter(
 *     description="Filter by rating",
 *     name="filter[rating]",
 *     in="query",
 *     @OA\Schema(ref="#/components/schemas/Rating"),
 *   ),
 *   @OA\Parameter(
 *     description="Filter by title, description or release year",
 *     name="filter[search]",
 *     in="query",
 *     @OA\Schema(
 *       type="string",
 *     )
 *   ),
 *   @OA\Parameter(ref="#/components/parameters/IncludeableInclude"),
 *   @OA\Parameter(ref="#/components/parameters/PageablePageNumber"),
 *   @OA\Parameter(ref="#/components/parameters/PageablePageSize"),
 *   @OA\Response(
 *     response="200",
 *     description="A collection of objects containing information about inventory",
 *     @OA\JsonContent(ref="#/components/schemas/InventoryCollection"),
 *   ),
 * )
 */
Route::get('/stores/{store}/inventory', InventoryController::class . '@indexByStore');

/**
 * @OA\Get(
 *   description="Retrieve the specified inventory",
 *   path="/inventory/{id}",
 *   tags={"inventory"},
 *   @OA\Parameter(
 *     name="id",
 *     description="A unique identifier for an inventory",
 *     in="path",
 *   ),
 *   @OA\Parameter(ref="#/components/parameters/IncludeableInclude"),
 *   @OA\Response(
 *     response="200",
 *     description="An object containing information for an inventory",
 *     @OA\JsonContent(ref="#/components/schemas/InventoryResource"),
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
Route::get('/inventory/{id}', InventoryController::class . '@show');

/**
 * @OA\Delete(
 *   description="Delete the specified inventory",
 *   path="/inventory/{id}",
 *   tags={"inventory"},
 *   @OA\Parameter(
 *     name="id",
 *     description="A unique identifier for an inventory",
 *     in="path",
 *   ),
 *   @OA\Response(
 *     response="200",
 *     description="The inventory was deleted successfully",
 *     @OA\JsonContent(ref="#/components/schemas/InventoryResource"),
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
Route::delete('/inventory/{id}', InventoryController::class . '@destroy');
