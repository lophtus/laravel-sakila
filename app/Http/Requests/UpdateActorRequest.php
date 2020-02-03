<?php

namespace App\Http\Requests;

use App\Sakila\Actor;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema()
 */
class UpdateActorRequest extends FormRequest
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
             * )
             */
            'first_name' => 'string',

            /**
             * @OA\Property(
             *   property="last_name",
             *   type="string",
             * )
             */
            'last_name' => 'string',
        ];
    }
}
