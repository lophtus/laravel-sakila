<?php

namespace App\Http\Requests;

use App\Sakila\Film;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *   required={
 *     "title",
 *     "rental_duration",
 *     "rental_rate",
 *     "replacement_cost",
 *   }
 * )
 */
class StoreFilmRequest extends FormRequest
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
             *   property="title",
             *   type="string",
             * )
             */
            'title' => 'string|required',

            /**
             * @OA\Property(
             *   property="description",
             *   type="string",
             *   nullable=true,
             * )
             */
            'description' => 'string|nullable',

            /**
             * @OA\Property(
             *   property="release_year",
             *   type="number",
             *   nullable=true,
             * )
             */
            'release_year' => 'integer|nullable',

            /**
             * @OA\Property(
             *   property="rental_duration",
             *   type="number",
             *   format="integer",
             *   default=3,
             *   minimum=3,
             *   maximum=7,
             * )
             */
            'rental_duration' => 'integer|required',

            /**
             * @OA\Property(
             *   property="rental_rate",
             *   type="number",
             *   default=4.99,
             * )
             */
            'rental_rate' => 'numeric|required',

            /**
             * @OA\Property(
             *   property="length",
             *   type="number",
             *   format="integer",
             *   nullable=true
             * )
             */
            'length' => 'integer|nullable',

            /**
             * @OA\Property(
             *   property="replacement_cost",
             *   type="number",
             * )
             */
            'replacement_cost' => 'numeric|required',

            /**
             * @OA\Property(
             *   property="rating",
             *   ref="#/components/schemas/Rating",
             * )
             */
            'rating' => 'string|nullable|in:' . implode(',', Film::RATINGS),

            /**
             * @OA\Property(
             *   property="special_features",
             *   ref="#/components/schemas/SpecialFeatures",
             * )
             */
            'special_features' => 'string|nullable',
        ];
    }
}
