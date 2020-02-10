<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema()
 */
class PaymentResource extends JsonResource
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
            'id' => $this->payment_id,

            /**
             * @OA\Property(
             *   property="customer",
             *   ref="#/components/schemas/CustomerResource",
             * )
             */
            'customer' => new CustomerResource($this->customer),

            /**
             * @OA\Property(
             *   property="rental",
             *   ref="#/components/schemas/RentalResource",
             * )
             */
            'rental' => new RentalResource($this->rental),

            /**
             * @OA\Property(
             *   property="staff",
             *   ref="#/components/schemas/StaffResource",
             * )
             */
            'staff' => new StaffResource($this->staff),

            /**
             * @OA\Property(
             *   property="amount",
             *   type="number",
             *   format="float",
             * )
             */
            'amount' => $this->amount,

            /**
             * @OA\Property(
             *   property="payment_date",
             *   type="string",
             *   format="date-time",
             * )
             */
            'payment_date' => $this->payment_date,

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
