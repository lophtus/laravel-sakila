<?php

namespace App\Http\Requests;

interface IncludeableRequest
{
    /**
     * @OA\Parameter(
     *   parameter="IncludeableInclude",
     *   description="A comma separated list of relationships to include",
     *   name="include",
     *   in="query",
     *   @OA\Schema(
     *     type="string",
     *   )
     * ),
     */
}
