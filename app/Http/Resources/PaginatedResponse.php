<?php

namespace App\Http\Resources;

/**
 * @OA\Schema(
 *   schema="PaginatedResponse",
 *   @OA\Property(
 *     property="links",
 *     @OA\Property(
 *       property="first",
 *       description="A uri for retrieving the first page of results.",
 *       type="string",
 *       format="uri",
 *     ),
 *     @OA\Property(
 *       property="last",
 *       description="A uri for retrieving the last page of results.",
 *       type="string",
 *       format="uri",
 *     ),
 *     @OA\Property(
 *       property="prev",
 *       description="A uri for retrieving the previous page of results.",
 *       type="string",
 *       format="uri",
 *       nullable=true,
 *     ),
 *     @OA\Property(
 *       property="next",
 *       description="A uri for retrieving the next page of results.",
 *       format="uri",
 *       type="string",
 *       nullable=true,
 *     ),
 *   ),
 *   @OA\Property(
 *     property="meta",
 *       @OA\Property(
 *         property="current_page",
 *         type="integer",
 *       ),
 *       @OA\Property(
 *         property="last_page",
 *         type="integer",
 *       ),
 *       @OA\Property(
 *         property="path",
 *         type="string",
 *         format="uri",
 *       ),
 *       @OA\Property(
 *         property="per_page",
 *         type="integer",
 *       ),
 *       @OA\Property(
 *         property="from",
 *         type="integer",
 *       ),
 *       @OA\Property(
 *         property="to",
 *         type="integer",
 *       ),
 *       @OA\Property(
 *         property="total",
 *         type="integer",
 *       ),
 *   )
 * )
 */
interface PaginatedResponse
{
}
