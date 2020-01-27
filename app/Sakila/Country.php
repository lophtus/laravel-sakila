<?php

namespace App\Sakila;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'country';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'country_id';

    /**
     * Returns the associated city
     *
     * @return City
     */
    public function city()
    {
        return $this->hasMany(City::class);
    }
}
