<?php

use Illuminate\Support\Facades\Route;

/**
 * @OA\Get(
 *   description="Retrieve a list of staffs",
 *   path="/staffs",
 *   tags={"staffs"},
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
 *     description="Filter by email",
 *     name="filter[email]",
 *     in="query",
 *     @OA\Schema(
 *       type="string",
 *       format="email",
 *     )
 *   ),
 *   @OA\Parameter(
 *     description="Filter by username",
 *     name="filter[username]",
 *     in="query",
 *     @OA\Schema(
 *       type="string",
 *     )
 *   ),
 *   @OA\Parameter(
 *     description="Filter by first name, last name, email or username",
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
 *     description="A collection of objects containing information about staffs",
 *     @OA\JsonContent(ref="#/components/schemas/StaffCollection"),
 *   ),
 * )
 */
Route::get('/staffs', 'Api\\StaffController@index');

/**
 * @OA\Get(
 *   description="Retrieve a list of staffs by store",
 *   path="/stores/{id}/staffs",
 *   tags={"staffs"},
 *   @OA\Parameter(
 *     description="A unique identifier for a store",
 *     name="id",
 *     in="path",
 *     @OA\Schema(
 *       type="integer",
 *     ),
 *   ),
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
 *     description="Filter by email",
 *     name="filter[email]",
 *     in="query",
 *     @OA\Schema(
 *       type="string",
 *       format="email",
 *     )
 *   ),
 *   @OA\Parameter(
 *     description="Filter by username",
 *     name="filter[username]",
 *     in="query",
 *     @OA\Schema(
 *       type="string",
 *     )
 *   ),
 *   @OA\Parameter(
 *     description="Filter by first name, last name, email or username",
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
 *     description="A collection of objects containing information about staffs",
 *     @OA\JsonContent(ref="#/components/schemas/StaffCollection"),
 *   ),
 * )
 */
Route::get('/stores/{store}/staffs', 'Api\StaffController@indexByStore');

/**
 * @OA\Get(
 *   description="Retrieve the specified staff",
 *   path="/staffs/{id}",
 *   tags={"staffs"},
 *   @OA\Parameter(
 *     name="id",
 *     description="A unique identifier for a staff",
 *     in="path",
 *   ),
 *   @OA\Response(
 *     response="200",
 *     description="An object containing information for a staff",
 *     @OA\JsonContent(ref="#/components/schemas/StaffResource"),
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
Route::get('/staffs/{id}', 'Api\\StaffController@show');

/**
 * @OA\Post(
 *   description="Create a new staff for the specified store",
 *   path="/stores/{id}/staffs",
 *   tags={"staffs"},
 *   @OA\Parameter(
 *     name="id",
 *     description="A unique identifier for a store",
 *     in="path",
 *     @OA\Schema(
 *       type="integer",
 *     ),
 *   ),
 *   @OA\RequestBody(
 *     description="An object containing information about a staff",
 *     @OA\JsonContent(ref="#/components/schemas/StoreStaffRequest"),
 *   ),
 *   @OA\Response(
 *     response="201",
 *     description="The object was created successfully",
 *     @OA\JsonContent(ref="#/components/schemas/StaffResource"),
 *   ),
 *   @OA\Response(
 *     response="422",
 *     ref="#/components/responses/ValidationErrorResponse",
 *   ),
 * )
 */
Route::post('/stores/{store}/staffs', 'Api\\StaffController@store');

/**
 * @OA\Patch(
 *   description="Update the specified staff",
 *   path="/staffs/{id}",
 *   tags={"staffs"},
 *   @OA\Parameter(
 *     name="id",
 *     description="A unique identifier for a staff",
 *     in="path",
 *   ),
 *   @OA\RequestBody(
 *     description="An object containing information about a staff",
 *     @OA\JsonContent(ref="#/components/schemas/UpdateStaffRequest"),
 *   ),
 *   @OA\Response(
 *     response="204",
 *     description="The staff was updated successfully",
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
Route::patch('/staffs/{id}', 'Api\\StaffController@update');

/**
 * @OA\Delete(
 *   description="Delete the specified staff",
 *   path="/staffs/{id}",
 *   tags={"staffs"},
 *   @OA\Parameter(
 *     name="id",
 *     description="A unique identifier for a staff",
 *     in="path",
 *   ),
 *   @OA\Response(
 *     response="200",
 *     description="The staff was deleted successfully",
 *     @OA\JsonContent(ref="#/components/schemas/StaffResource"),
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
Route::delete('/staffs/{id}', 'Api\\StaffController@destroy');
