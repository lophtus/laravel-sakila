<?php

/** Customer route definitions */

use App\Http\Controllers\Admin\Api\CustomerController;
use Illuminate\Support\Facades\Route;

/**
 * @OA\Get(
 *   description="Retrieve a list of customers",
 *   path="/customers",
 *   tags={"customers"},
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
 *     description="Filter by first name, last name or email",
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
 *     description="A collection of objects containing information about customers",
 *     @OA\JsonContent(ref="#/components/schemas/CustomerCollection"),
 *   ),
 * )
 */
Route::get('/customers', CustomerController::class . '@index');

/**
 * @OA\Get(
 *   description="Retrieve a list of customers by store",
 *   path="/stores/{id}/customers",
 *   tags={"customers", "stores"},
 *   @OA\Parameter(
 *     name="id",
 *     description="A unique identifier for a store",
 *     in="path",
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
 *     )
 *   ),
 *   @OA\Parameter(
 *     description="Filter by first name, last name or email",
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
 *     description="A collection of objects containing information about customers",
 *     @OA\JsonContent(ref="#/components/schemas/CustomerCollection"),
 *   ),
 * )
 */
Route::get('/stores/{store}/customers', CustomerController::class . '@indexByStore');

/**
 * @OA\Get(
 *   description="Retrieve the specified customer",
 *   path="/customers/{id}",
 *   tags={"customers"},
 *   @OA\Parameter(
 *     name="id",
 *     description="A unique identifier for a customer",
 *     in="path",
 *   ),
 *   @OA\Response(
 *     response="200",
 *     description="An object containing information for a customer",
 *     @OA\JsonContent(ref="#/components/schemas/CustomerResource"),
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
Route::get('/customers/{id}', CustomerController::class . '@show');

/**
 * @OA\Post(
 *   description="Create a new customer for the specified store",
 *   path="/stores/{id}/customers",
 *   tags={"customers"},
 *   @OA\Parameter(
 *     name="id",
 *     description="",
 *     in="path",
 *   ),
 *   @OA\RequestBody(
 *     description="An object containing information about a customer",
 *     @OA\JsonContent(ref="#/components/schemas/StoreCustomerRequest"),
 *   ),
 *   @OA\Response(
 *     response="201",
 *     description="The object was created successfully",
 *     @OA\JsonContent(ref="#/components/schemas/CustomerResource"),
 *   ),
 *   @OA\Response(
 *     response="422",
 *     ref="#/components/responses/ValidationErrorResponse",
 *   ),
 * )
 */
Route::post('/stores/{store}/customers', CustomerController::class . '@store');

/**
 * @OA\Patch(
 *   description="Update the specified customer",
 *   path="/customers/{id}",
 *   tags={"customers"},
 *   @OA\Parameter(
 *     name="id",
 *     description="A unique identifier for a customer",
 *     in="path",
 *   ),
 *   @OA\RequestBody(
 *     description="An object containing information about a customer",
 *     @OA\JsonContent(ref="#/components/schemas/UpdateCustomerRequest"),
 *   ),
 *   @OA\Response(
 *     response="204",
 *     description="The customer was updated successfully",
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
Route::patch('/customers/{id}', CustomerController::class . '@update');

/**
 * @OA\Delete(
 *   description="Delete the specified customer",
 *   path="/customers/{id}",
 *   tags={"customers"},
 *   @OA\Parameter(
 *     name="id",
 *     description="A unique identifier for a customer",
 *     in="path",
 *   ),
 *   @OA\Response(
 *     response="200",
 *     description="The customer was deleted successfully",
 *     @OA\JsonContent(ref="#/components/schemas/CustomerResource"),
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
Route::delete('/customers/{id}', CustomerController::class . '@destroy');
