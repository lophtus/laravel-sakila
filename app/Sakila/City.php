<?php

namespace App\Sakila;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'city';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'city_id';

    /**
     * Returns the associated country
     *
     * @return Country
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
