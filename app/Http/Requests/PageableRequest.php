<?php

namespace App\Http\Requests;

interface PageableRequest
{
    /**
     * @OA\Parameter(
     *   parameter="PageablePageNumber",
     *   description="The page number to return",
     *   name="page[number]",
     *   in="query",
     *   @OA\Schema(
     *     type="number",
     *     format="integer",
     *     default=1,
     *   )
     * ),
     */

    /**
     * @OA\Parameter(
     *   parameter="PageablePageSize",
     *   description="The maximum number of results per request",
     *   name="page[size]",
     *   in="query",
     *   @OA\Schema(
     *     type="number",
     *     format="integer",
     *     default=30,
     *   )
     * ),
     */
}
