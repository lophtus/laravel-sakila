<?php

namespace App\Sakila;

use App\Sakila\Concerns\HasFillableRelations;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFillableRelations;

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
     * The relations that are mass assignable.
     *
     * @var array
     */
    protected $fillable_relations = [
        'address'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'active' => 'boolean',
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
     * Returns the associated address
     *
     * @return Address
     */
    public function address()
    {
        return $this->belongsTo(Address::class, 'address_id', 'address_id')->withDefault();
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
        return $this->belongsTo(Store::class, 'store_id', 'store_id');
    }
}
