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
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'country' => 'US',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'address',
        'address2',
        'city',
        'state',
        'country',
        'postal_code',
        'phone',
    ];
}
