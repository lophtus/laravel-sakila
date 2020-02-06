<?php

namespace App\Http\DTOs;

use Illuminate\Http\Request;

abstract class AbstractData
{
    /**
     * Extract data from a request
     *
     * @param Request $request
     * @return array
     */
    abstract public static function fromRequest(Request $request);

    /**
     * Extracts an attribute from request
     *
     * @param Request $request
     * @param string $attr
     * @return MissingValue|mixed
     */
    protected static function extractAttribute(Request $request, $attr)
    {
        return $request->has($attr) ? $request->input($attr) : new MissingValue();
    }

    /**
     * Removes missing values from array
     *
     * @param array $values
     * @return array
     */
    protected static function removeMissingValues(array $values)
    {
        return self::filterValues($values, function ($var) {
            return (! $var instanceof MissingValue);
        });
    }

    /**
     * Filters values by callback
     *
     * @param array $input
     * @param callable $callback
     * @return array
     */
    protected static function filterValues($input, $callback = null)
    {
        $original = $input;

        $input = array_filter($input, $callback);

        $input = array_map(function ($e) use ($callback) {
            return is_array($e) ? self::filterValues($e, $callback) : $e;
        }, $input);

        return $original === $input ? $input : self::filterValues($input, $callback);
    }
}
