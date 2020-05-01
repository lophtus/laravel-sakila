<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema()
 */
class InventoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            /**
             * @OA\Property(
             *   property="id",
             *   type="integer",
             *   readOnly=true,
             * )
             */
            'id' => $this->inventory_id,

            /**
             * @OA\Property(
             *   property="store",
             *   ref="#/components/schemas/StoreResource",
             * )
             */
            'store' => StoreResource::make($this->whenLoaded('store')),

            /**
             * @OA\Property(
             *   property="film",
             *   ref="#/components/schemas/FilmResource",
             * )
             */
            'film' => FilmResource::make($this->whenLoaded('film')),

            /**
             * @OA\Property(
             *   property="created_at",
             *   type="string",
             *   format="date-time",
             *   readOnly=true,
             * )
             */
            'created_at' => $this->created_at,

            /**
             * @OA\Property(
             *   property="updated_at",
             *   type="string",
             *   format="date-time",
             *   readOnly=true,
             * )
             */
            'updated_at' => $this->updated_at,
        ];
    }
}
