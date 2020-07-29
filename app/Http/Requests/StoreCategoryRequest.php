<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *   required={
 *     "name",
 *   }
 * )
 */
class StoreCategoryRequest extends FormRequest
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
             *   property="name",
             *   type="string",
             *   maxLength=25,
             * )
             */
            'name' => 'string|required|max:25',
        ];
    }
}
