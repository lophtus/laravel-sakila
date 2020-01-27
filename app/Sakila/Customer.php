<?php

namespace App\Sakila;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'customer';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'customer_id';

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'active' => true,
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'store_id',
        'first_name',
        'last_name',
        'email',
        'address_id',
        'active',
    ];

    /**
     * Returns the associated address
     *
     * @return Address
     */
    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    /**
     * Returns a collection of associated payments
     *
     * @return Collection<Payment>
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Returns a collection of associated rentals
     *
     * @return Collection<Rental>
     */
    public function rentals()
    {
        return $this->hasMany(Rental::class);
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
