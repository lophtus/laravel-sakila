<?php

namespace App\Sakila;

use App\Sakila\Concerns\HasFillableRelations;
use Database\Factories\StoreFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;
    use HasFillableRelations;

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
     * The relations that are mass assignable.
     *
     * @var array
     */
    protected $fillable_relations = [
        'address'
    ];

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = [
        'address',
    ];

    /**
     * Returns the associate address
     *
     * @return Address
     */
    public function address()
    {
        return $this->belongsTo(Address::class, 'address_id', 'address_id')->withDefault();
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
     * Returns a collection of associated films from inventory
     *
     * @return Collection<Film>
     */
    public function films()
    {
        return $this->hasManyThrough(Film::class, Inventory::class, 'store_id', 'film_id', 'store_id', 'film_id');
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

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory(): StoreFactory
    {
        return StoreFactory::new();
    }
}
