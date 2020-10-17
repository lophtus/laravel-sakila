<?php

namespace App\Http\Resources\Auth;

use App\Http\Resources\StoreResource;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema()
 */
class AuthResource extends JsonResource
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
             *   property="first_name",
             *   type="string",
             *   readOnly=true,
             * )
             */
            'first_name' => $this->first_name,

            /**
             * @OA\Property(
             *   property="last_name",
             *   type="string",
             *   readOnly=true,
             * )
             */
            'last_name' => $this->last_name,

            /**
             * @OA\Property(
             *   property="email",
             *   type="string",
             *   format="email",
             *   readOnly=true,
             * )
             */
            'email' => $this->email,

            /**
             * @OA\Property(
             *   property="store",
             *   ref="#/components/schemas/StoreResource",
             *   readOnly=true,
             * )
             */
            'store' => StoreResource::make($this->whenLoaded('store')),

            /**
             * @OA\Property(
             *   property="access_token",
             *   type="string",
             *   readOnly=true,
             * )
             */
            'access_token' => $this->access_token,

            /**
             * @OA\Property(
             *   property="permissions",
             *   type="string",
             *   readOnly=true,
             * )
             */
            'permission' => $this->permissions,
        ];
    }
}
