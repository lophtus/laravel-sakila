<?php

namespace App\Http\Requests;

use App\Sakila\Film;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *   required={
 *     "first_name",
 *     "last_name",
 *   }
 * )
 */
class StoreActorRequest extends FormRequest
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
             *   maximum=45,
             * )
             */
            'first_name' => 'string|required',

            /**
             * @OA\Property(
             *   property="last_name",
             *   type="string",
             *   maximum=45,
             * )
             */
            'last_name' => 'string|required',
        ];
    }
}
