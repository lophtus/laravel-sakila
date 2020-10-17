<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *   required={
 *     "email",
 *     "password",
 *   }
 * )
 */
class AuthRequest extends FormRequest
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
             *   property="email",
             *   type="string",
             *   maxLength=50,
             * )
             */
            'email' => 'string|required|max:50',

            /**
             * @OA\Property(
             *   property="password",
             *   type="string",
             * )
             */
            'password' => 'string|required',
        ];
    }
}
