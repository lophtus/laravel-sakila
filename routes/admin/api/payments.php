<?php

use App\Http\Controllers\Admin\Api\PaymentController;
use Illuminate\Support\Facades\Route;

/**
 * @OA\Get(
 *   description="Retrieve a list of payments",
 *   path="/payments",
 *   tags={"payments"},
 *   @OA\Parameter(ref="#/components/parameters/PageablePageNumber"),
 *   @OA\Parameter(ref="#/components/parameters/PageablePageSize"),
 *   @OA\Response(
 *     response="200",
 *     description="A collection of objects containing information about payments",
 *     @OA\JsonContent(ref="#/components/schemas/PaymentCollection"),
 *   ),
 * )
 */
Route::get('/payments', PaymentController::class . '@index');

/**
 * @OA\Get(
 *   description="Retrieve a list of payments by customer",
 *   path="/customers/{id}/payments",
 *   tags={"customers", "payments"},
 *   @OA\Parameter(
 *     name="id",
 *     description="A unique identifier for a customer",
 *     in="path",
 *   ),
 *   @OA\Parameter(ref="#/components/parameters/PageablePageNumber"),
 *   @OA\Parameter(ref="#/components/parameters/PageablePageSize"),
 *   @OA\Response(
 *     response="200",
 *     description="A collection of objects containing information about payments",
 *     @OA\JsonContent(ref="#/components/schemas/PaymentCollection"),
 *   ),
 * )
 */
Route::get('/customers/{customer}/payments', PaymentController::class . '@indexByCustomer');

/**
 * @OA\Get(
 *   description="Retrieve the specified payment",
 *   path="/payments/{id}",
 *   tags={"payments"},
 *   @OA\Parameter(
 *     name="id",
 *     description="A unique identifier for a payment",
 *     in="path",
 *   ),
 *   @OA\Response(
 *     response="200",
 *     description="An object containing information for a payment",
 *     @OA\JsonContent(ref="#/components/schemas/PaymentResource"),
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
Route::get('/payments/{id}', PaymentController::class . '@show');

/**
 * @OA\Delete(
 *   description="Delete the specified payment",
 *   path="/payments/{id}",
 *   tags={"payments"},
 *   @OA\Parameter(
 *     name="id",
 *     description="A unique identifier for a payment",
 *     in="path",
 *   ),
 *   @OA\Response(
 *     response="200",
 *     description="The payment was deleted successfully",
 *     @OA\JsonContent(ref="#/components/schemas/PaymentResource"),
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
Route::delete('/payments/{id}', PaymentController::class . '@destroy');
