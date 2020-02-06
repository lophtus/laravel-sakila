<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema()
 */
class UpdateStaffRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            /**
             * @OA\Property(
             *   property="first_name",
             *   type="string",
             *   maxLength=45,
             * )
             */
            'first_name' => 'string|max:45',

            /**
             * @OA\Property(
             *   property="last_name",
             *   type="string",
             *   maxLength=45,
             * )
             */
            'last_name' => 'string|max:45',

            /**
             * @OA\Property(
             *   property="email",
             *   type="string",
             *   format="email",
             *   maxLength=50,
             * )
             */
            'email' => 'email|max:50',

            /**
             * @OA\Property(
             *   property="address",
             *   type="string",
             *   maxLength=50,
             * )
             */
            'address' => 'string|max:50',

            /**
             * @OA\Property(
             *   property="address2",
             *   type="string",
             *   nullable=true,
             *   maxLength=50,
             * )
             */
            'address2' => 'string|nullable|max:50',

            /**
             * @OA\Property(
             *   property="city",
             *   type="string",
             *   maxLength=50,
             * )
             */
            'city' => 'string|max:50',

            /**
             * @OA\Property(
             *   property="state",
             *   type="string",
             *   minLength=2,
             *   maxLength=2,
             * )
             */
            'state' => 'string|size:2',

            /**
             * @OA\Property(
             *   property="country",
             *   type="string",
             *   minLength=2,
             *   maxLength=2,
             * )
             */
            'country' => 'string|size:2',

            /**
             * @OA\Property(
             *   property="postal_code",
             *   type="string",
             *   maxLength=10,
             * )
             */
            'postal_code' => 'string|max:10',

            /**
             * @OA\Property(
             *   property="phone",
             *   type="string",
             *   maxLength=20,
             * )
             */
            'phone' => 'string|max:20',

            /**
             * @OA\Property(
             *   property="active",
             *   type="boolean",
             *   default=true,
             * )
             */
            'active' => 'boolean',
        ];
    }
}
