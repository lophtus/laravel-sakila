<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema()
 */
class AddressResource extends JsonResource
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
            'id' => $this->address_id,

            /**
             * @OA\Property(
             *   property="address",
             *   type="string",
             *   maxLength=50,
             * )
             */
            'address' => $this->address,

            /**
             * @OA\Property(
             *   property="address2",
             *   type="string",
             *   maxLength=50,
             *   nullable=true,
             * )
             */
            'address2' => $this->address2,

            /**
             * @OA\Property(
             *   property="city",
             *   type="string",
             *   maxLength=50,
             * )
             */
            'city' => $this->city,

            /**
             * @OA\Property(
             *   property="state",
             *   type="string",
             *   minLength=2,
             *   maxLength=2,
             * )
             */
            'state' => $this->state,

            /**
             * @OA\Property(
             *   property="country",
             *   type="string",
             *   minLength=2,
             *   maxLength=2,
             * )
             */
            'country' => $this->country,

            /**
             * @OA\Property(
             *   property="postal_code",
             *   type="string",
             *   maxLength=10,
             * )
             */
            'postal_code' => $this->postal_code,

            /**
             * @OA\Property(
             *   property="phone",
             *   type="string",
             *   maxLength=20,
             * )
             */
            'phone' => $this->phone,

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
