<?php

namespace App\Http\DTOs;

use Illuminate\Http\Request;

class StoreData extends AbstractData
{
    /**
     * {@inheritDoc}
     */
    public static function fromRequest(Request $request)
    {
        return self::removeMissingValues([
            'address' => [
                'address' => self::extractAttribute($request, 'address'),
                'address2' => self::extractAttribute($request, 'address2'),
                'city' => self::extractAttribute($request, 'city'),
                'state' => self::extractAttribute($request, 'state'),
                'country' => self::extractAttribute($request, 'country'),
                'postal_code' => self::extractAttribute($request, 'postal_code'),
                'phone' => self::extractAttribute($request, 'phone'),
            ],
        ]);
    }
}
