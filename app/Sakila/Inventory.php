<?php

namespace App\Sakila;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'inventory';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'inventory_id';

    /**
     * Returns the associated film
     *
     * @return Film
     */
    public function film()
    {
        return $this->belongsTo(Film::class);
    }

    /**
     * Returns the associated store
     *
     * @return Store
     */
    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}
