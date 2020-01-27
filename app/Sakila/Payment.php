<?php

namespace App\Sakila;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'payment';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'payment_id';

    /**
     * Returns the associated customer
     *
     * @return Customer
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Returns the associated rental if defined; otherwise null
     *
     * @return Rental|null
     */
    public function rental()
    {
        return $this->belongsTo(Rental::class);
    }

    /**
     * Returns the associated staff
     *
     * @return Staff
     */
    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }
}
