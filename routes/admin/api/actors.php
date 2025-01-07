<?php

/** Actor route definitions */

use App\Http\Controllers\Admin\Api\ActorController;
use Illuminate\Support\Facades\Route;

/**
 * @OA\Get(
 *   description="Retrieve a list of actors",
 *   path="/actors",
 *   tags={"actors"},
 *   @OA\Parameter(
 *     description="Filter by first name",
 *     name="filter[first_name]",
 *     in="query",
 *     @OA\Schema(
 *       type="string",
 *     )
 *   ),
 *   @OA\Parameter(
 *     description="Filter by last name",
 *     name="filter[last_name]",
 *     in="query",
 *     @OA\Schema(
 *       type="string",
 *     )
 *   ),
 *   @OA\Parameter(
 *     description="Filter by first name or last name",
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
 *     description="A collection of objects containing information about actors",
 *     @OA\JsonContent(ref="#/components/schemas/ActorCollection"),
 *   ),
 * )
 */
Route::get('/actors', ActorController::class . '@index');

/**
 * @OA\Get(
 *   description="Retrieve the specified actor",
 *   path="/actors/{id}",
 *   tags={"actors"},
 *   @OA\Parameter(
 *     name="id",
 *     description="A unique identifier for a actor",
 *     in="path",
 *   ),
 *   @OA\Response(
 *     response="200",
 *     description="An object containing information for a actor",
 *     @OA\JsonContent(ref="#/components/schemas/ActorResource"),
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
Route::get('/actors/{id}', ActorController::class . '@show');

/**
 * @OA\Post(
 *   description="Create a new actor",
 *   path="/actors",
 *   tags={"actors"},
 *   @OA\RequestBody(
 *     description="An object containing information about a actor",
 *     @OA\JsonContent(ref="#/components/schemas/StoreActorRequest"),
 *   ),
 *   @OA\Response(
 *     response="201",
 *     description="The object was created successfully",
 *     @OA\JsonContent(ref="#/components/schemas/ActorResource"),
 *   ),
 *   @OA\Response(
 *     response="422",
 *     ref="#/components/responses/ValidationErrorResponse",
 *   ),
 * )
 */
Route::post('/actors', ActorController::class . '@store');

/**
 * @OA\Patch(
 *   description="Update the specified actor",
 *   path="/actors/{id}",
 *   tags={"actors"},
 *   @OA\Parameter(
 *     name="id",
 *     description="A unique identifier for a actor",
 *     in="path",
 *   ),
 *   @OA\RequestBody(
 *     description="An object containing information about a actor",
 *     @OA\JsonContent(ref="#/components/schemas/UpdateActorRequest"),
 *   ),
 *   @OA\Response(
 *     response="204",
 *     description="The actor was updated successfully",
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
Route::patch('/actors/{id}', ActorController::class . '@update');

/**
 * @OA\Delete(
 *   description="Delete the specified actor",
 *   path="/actors/{id}",
 *   tags={"actors"},
 *   @OA\Parameter(
 *     name="id",
 *     description="A unique identifier for a actor",
 *     in="path",
 *   ),
 *   @OA\Response(
 *     response="200",
 *     description="The actor was deleted successfully",
 *     @OA\JsonContent(ref="#/components/schemas/ActorResource"),
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
Route::delete('/actors/{id}', ActorController::class . '@destroy');
