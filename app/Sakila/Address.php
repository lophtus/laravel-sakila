<?php

namespace App\Sakila;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'address';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'address_id';

    /**
     * Returns the associated city
     *
     * @return City
     */
    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
