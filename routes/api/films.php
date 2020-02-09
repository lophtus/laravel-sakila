<?php

use Illuminate\Support\Facades\Route;

/**
 * @OA\Get(
 *   description="Retrieve a list of films",
 *   path="/films",
 *   tags={"films"},
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
 *   @OA\Parameter(ref="#/components/parameters/PageablePageNumber"),
 *   @OA\Parameter(ref="#/components/parameters/PageablePageSize"),
 *   @OA\Response(
 *     response="200",
 *     description="A collection of objects containing information about films",
 *     @OA\JsonContent(ref="#/components/schemas/FilmCollection"),
 *   ),
 * )
 */
Route::get('/films', 'Api\\FilmController@index');

/**
 * @OA\Get(
 *   description="Retrieve a list of films by store",
 *   path="/stores/{id}/films",
 *   tags={"films"},
 *   @OA\Parameter(
 *     name="id",
 *     description="A unique identifier for a store",
 *     in="path",
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
 *   @OA\Parameter(ref="#/components/parameters/PageablePageNumber"),
 *   @OA\Parameter(ref="#/components/parameters/PageablePageSize"),
 *   @OA\Response(
 *     response="200",
 *     description="A collection of objects containing information about films",
 *     @OA\JsonContent(ref="#/components/schemas/FilmCollection"),
 *   ),
 * )
 */
Route::get('/stores/{store}/films', 'Api\\FilmController@indexByStore');

/**
 * @OA\Get(
 *   description="Retrieve the specified film",
 *   path="/films/{id}",
 *   tags={"films"},
 *   @OA\Parameter(
 *     name="id",
 *     description="A unique identifier for a film",
 *     in="path",
 *   ),
 *   @OA\Response(
 *     response="200",
 *     description="An object containing information for a film",
 *     @OA\JsonContent(ref="#/components/schemas/FilmResource"),
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
Route::get('/films/{id}', 'Api\\FilmController@show');

/**
 * @OA\Post(
 *   description="Create a new film",
 *   path="/films",
 *   tags={"films"},
 *   @OA\RequestBody(
 *     description="An object containing information about a film",
 *     @OA\JsonContent(ref="#/components/schemas/StoreFilmRequest"),
 *   ),
 *   @OA\Response(
 *     response="201",
 *     description="The object was created successfully",
 *     @OA\JsonContent(ref="#/components/schemas/FilmResource"),
 *   ),
 *   @OA\Response(
 *     response="422",
 *     ref="#/components/responses/ValidationErrorResponse",
 *   ),
 * )
 */
Route::post('/films', 'Api\\FilmController@store');

/**
 * @OA\Patch(
 *   description="Update the specified film",
 *   path="/films/{id}",
 *   tags={"films"},
 *   @OA\Parameter(
 *     name="id",
 *     description="A unique identifier for a film",
 *     in="path",
 *   ),
 *   @OA\RequestBody(
 *     description="An object containing information about a film",
 *     @OA\JsonContent(ref="#/components/schemas/UpdateFilmRequest"),
 *   ),
 *   @OA\Response(
 *     response="204",
 *     description="The film was updated successfully",
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
Route::patch('/films/{id}', 'Api\\FilmController@update');

/**
 * @OA\Delete(
 *   description="Delete the specified film",
 *   path="/films/{id}",
 *   tags={"films"},
 *   @OA\Parameter(
 *     name="id",
 *     description="A unique identifier for a film",
 *     in="path",
 *   ),
 *   @OA\Response(
 *     response="200",
 *     description="The film was deleted successfully",
 *     @OA\JsonContent(ref="#/components/schemas/FilmResource"),
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
Route::delete('/films/{id}', 'Api\\FilmController@destroy');
