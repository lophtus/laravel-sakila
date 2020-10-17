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
 *     description="A collection of objects containing information about films",
 *     @OA\JsonContent(ref="#/components/schemas/FilmCollection"),
 *   ),
 * )
 */
Route::get('/films', 'Api\\FilmController@index');

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
 *   @OA\Parameter(ref="#/components/parameters/IncludeableInclude"),
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
 * @OA\Get(
 *   description="Retrieve a list of films by category",
 *   path="/categories/{id}/films",
 *   tags={"films"},
 *   @OA\Parameter(
 *     name="id",
 *     description="A unique identifier for a category",
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
 *     description="A collection of objects containing information about films",
 *     @OA\JsonContent(ref="#/components/schemas/FilmCollection"),
 *   ),
 * )
 */
Route::get('/categories/{category}/films', 'Api\\FilmController@indexByCategory');
