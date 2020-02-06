<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema()
 */
class StaffResource extends JsonResource
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
            'id' => $this->staff_id,

            /**
             * @OA\Property(
             *   property="username",
             *   type="string",
             *   maxLength=45,
             *   readOnly=true,
             * )
             */
            'username' => $this->username,

            /**
             * @OA\Property(
             *   property="first_name",
             *   type="string",
             *   maxLength=45,
             * )
             */
            'first_name' => $this->first_name,

            /**
             * @OA\Property(
             *   property="last_name",
             *   type="string",
             *   maxLength=45,
             * )
             */
            'last_name' => $this->last_name,

            /**
             * @OA\Property(
             *   property="email",
             *   type="string",
             *   format="email",
             *   maxLength=50,
             * )
             */
            'email' => $this->email,

            /**
             * @OA\Property(
             *   property="address",
             *   type="string",
             *   maxLength=50,
             * )
             */
            'address' => $this->address->address,

            /**
             * @OA\Property(
             *   property="address2",
             *   type="string",
             *   maxLength=50,
             *   nullable=true,
             * )
             */
            'address2' => $this->address->address2,

            /**
             * @OA\Property(
             *   property="city",
             *   type="string",
             *   maxLength=50,
             * )
             */
            'city' => $this->address->city,

            /**
             * @OA\Property(
             *   property="state",
             *   type="string",
             *   minLength=2,
             *   maxLength=2,
             * )
             */
            'state' => $this->address->state,

            /**
             * @OA\Property(
             *   property="country",
             *   type="string",
             *   minLength=2,
             *   maxLength=2,
             * )
             */
            'country' => $this->address->country,

            /**
             * @OA\Property(
             *   property="postal_code",
             *   type="string",
             *   maxLength=10,
             * )
             */
            'postal_code' => $this->address->postal_code,

            /**
             * @OA\Property(
             *   property="phone",
             *   type="string",
             *   maxLength=20,
             * )
             */
            'phone' => $this->address->phone,

            /**
             * @OA\Property(
             *   property="active",
             *   type="boolean",
             *   default=true,
             * )
             */
            'active' => $this->active,

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
