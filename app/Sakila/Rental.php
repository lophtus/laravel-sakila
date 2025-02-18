<?php

namespace App\Sakila;

use Database\Factories\RentalFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'rental';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'rental_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'rental_date',
        'return_date',
    ];

    /**
     * Returns the associated customer
     *
     * @return Customer
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'customer_id');
    }

    /**
     * Returns the associated inventory
     *
     * @return Inventory
     */
    public function inventory()
    {
        return $this->belongsTo(Inventory::class, 'inventory_id', 'inventory_id');
    }

    /**
     * Returns the associated payment
     *
     * @return Payment
     */
    public function payment()
    {
        return $this->hasOne(Payment::class, 'rental_id', 'rental_id');
    }

    /**
     * Returns the associated staff
     *
     * @return Staff
     */
    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_id', 'staff_id');
    }

    /**
     * Returns the associated store
     *
     * @return Store
     */
    public function store()
    {
        return $this->hasOneThrough(Store::class, Inventory::class, 'inventory_id', 'store_id', 'inventory_id', 'store_id');
    }

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory(): RentalFactory
    {
        return RentalFactory::new();
    }
}
