<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema()
 */
class FilmResource extends JsonResource
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
            'id' => $this->film_id,

            /**
             * @OA\Property(
             *   property="title",
             *   type="string",
             *   maxLength=255,
             * )
             */
            'title' => $this->title,

            /**
             * @OA\Property(
             *   property="description",
             *   type="string",
             *   nullable=true,
             * )
             */
            'description' => $this->description,

            /**
             * @OA\Property(
             *   property="release_year",
             *   type="integer",
             * )
             */
            'release_year' => $this->release_year,

            /**
             * @OA\Property(
             *   property="length",
             *   type="integer",
             * )
             */
            'length' => $this->length,

            /**
             * @OA\Property(
             *   property="language",
             *   type="string",
             *   nullable=true,
             * )
             */
            'language' => $this->whenLoaded('language', function () {
                return $this->language->name;
            }),

            /**
             * @OA\Property(
             *   property="original_language",
             *   type="string",
             *   nullable=true,
             * )
             */
            'original_language' => $this->whenLoaded('originalLanguage', function () {
                return $this->originalLanguage->name;
            }),

            /**
             * @OA\Property(
             *   property="rating",
             *   ref="#/components/schemas/Rating",
             * )
             */
            'rating' => $this->rating,

            /**
             * @OA\Property(
             *   property="special_features",
             *   ref="#/components/schemas/SpecialFeatures",
             * )
             */
            'special_features' => $this->special_features,

            /**
             * @OA\Property(
             *   property="rental_duration",
             *   type="integer",
             * )
             */
            'rental_duration' => $this->rental_duration,

            /**
             * @OA\Property(
             *   property="rental_rate",
             *   type="number",
             *   format="float",
             * )
             */
            'rental_rate' => $this->rental_rate,

            /**
             * @OA\Property(
             *   property="replacement_cost",
             *   type="number",
             *   format="float",
             * )
             */
            'replacement_cost' => $this->replacement_cost,

            /**
             * @OA\Property(
             *   property="actors",
             *   type="array",
             *   @OA\Items(ref="#/components/schemas/ActorResource"),
             * )
             */
            'actors' => ActorResource::collection($this->whenLoaded('actors')),

            /**
             * @OA\Property(
             *   property="inventory",
             *   type="array",
             *   @OA\Items(ref="#/components/schemas/InventoryResource"),
             * )
             */
            'inventory' => InventoryResource::collection($this->whenLoaded('inventory')),

            /**
             * @OA\Property(
             *   property="in_stock_inventory",
             *   type="array",
             *   @OA\Items(ref="#/components/schemas/InventoryResource"),
             * )
             */
            'in_stock_inventory' => InventoryResource::collection($this->whenLoaded('inStockInventory')),

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
