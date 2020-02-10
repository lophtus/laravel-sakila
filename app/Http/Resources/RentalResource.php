<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema()
 */
class RentalResource extends JsonResource
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
            'id' => $this->rental_id,

            /**
             * @OA\Property(
             *   property="rental_date",
             *   type="string",
             *   format="date-time",
             * )
             */
            'rented_date' => $this->rental_date,

            /**
             * @OA\Property(
             *   property="return_date",
             *   type="string",
             *   format="date-time",
             * )
             */
            'return_date' => $this->return_date,

            /**
             * @OA\Property(
             *   property="inventory",
             *   ref="#/components/schemas/InventoryResource",
             * )
             */
            'inventory' => new InventoryResource($this->inventory),

            /**
             * @OA\Property(
             *   property="customer",
             *   ref="#/components/schemas/CustomerResource",
             * )
             */
            'customer' => new CustomerResource($this->customer),

            /**
             * @OA\Property(
             *   property="staff",
             *   ref="#/components/schemas/StaffResource",
             * )
             */
            'staff' => new StaffResource($this->staff),

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
