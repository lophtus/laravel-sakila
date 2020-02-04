<?php

namespace App\Sakila;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'store';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'store_id';

    /**
     * Returns the associate address
     *
     * @return Address
     */
    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    /**
     * Returns a collection of associated customers
     *
     * @return Collection<Customer>
     */
    public function customers()
    {
        return $this->hasMany(Customer::class, 'store_id', 'store_id');
    }

    /**
     * Return a collection of associated inventory
     *
     * @return Collection<Inventory>
     */
    public function inventory()
    {
        return $this->hasMany(Inventory::class, 'store_id', 'store_id');
    }

    /**
     * Returns the associated manager
     *
     * @return Staff
     */
    public function manager()
    {
        return $this->belongsTo(Staff::class, 'manager_staff_id', 'staff_id');
    }

    /**
     * Returns a collection of associated staff
     *
     * @return Collection<Staff>
     */
    public function staff()
    {
        return $this->hasMany(Staff::class, 'store_id');
    }
}
