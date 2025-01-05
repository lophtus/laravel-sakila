<?php

namespace App\Sakila;

use App\Sakila\Concerns\HasFillableRelations;
use Database\Factories\StaffFactory;
use GregoryDuckworth\Encryptable\EncryptableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use EncryptableTrait;
    use HasFactory;
    use HasFillableRelations;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'staff';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'staff_id';

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'active' => true,
    ];

    /**
     * The attributes that are encrypted.
     *
     * @var array
     */
    protected $encryptable = [
        'password',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'password',
        'first_name',
        'last_name',
        'email',
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
     * Returns the associated store
     *
     * @return Store
     */
    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id', 'store_id');
    }

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory(): StaffFactory
    {
        return StaffFactory::new();
    }
}
