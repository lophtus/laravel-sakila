<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * @OA\Schema(
 *   allOf={
 *     @OA\Schema(ref="#/components/schemas/PaginatedResponse"),
 *   }
 * )
 */
class ActorCollection extends ResourceCollection implements PaginatedResponse
{
    /** @var string */
    public $collects = ActorResource::class;

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            /**
             * @OA\Property(
             *   property="data",
             *   type="array",
             *   @OA\Items(ref="#/components/schemas/ActorResource"),
             * )
             */
            'data' => $this->collection,
        ];
    }
}
