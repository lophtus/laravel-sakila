<?php

use Illuminate\Support\Facades\Route;

/**
 * @OA\Get(
 *   description="Retrieve a list of suggested films & categories",
 *   path="/my/suggestions",
 *   tags={"customer"},
 *   @OA\Response(
 *     response="200",
 *     description="A collection of objects containing information about suggestions",
 *     @OA\JsonContent(ref="#/components/schemas/CategoryCollection"),
 *   ),
 * )
 */
Route::get('/my/suggestions', 'Api\CustomerController@getSuggestions');
