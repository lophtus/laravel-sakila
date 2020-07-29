<?php

namespace App\Http\DTOs;

use Illuminate\Http\Request;

class CategoryData extends AbstractData
{
    /**
     * {@inheritDoc}
     */
    public static function fromRequest(Request $request)
    {
        return self::removeMissingValues([
            'name' => self::extractAttribute($request, 'name'),
        ]);
    }
}
