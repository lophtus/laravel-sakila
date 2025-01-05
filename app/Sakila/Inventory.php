<?php

namespace App\Sakila;

use Database\Factories\InventoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Inventory extends Model
{
    use HasFactory;

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
        return $this->belongsTo(Film::class, 'film_id', 'film_id');
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
     * Returns true if in stock; false otherwise
     *
     * @return bool
     */
    public function isInStock()
    {
        $result = collect(
            DB::select('SELECT inventory_in_stock(?) as is_in_stock', [$this->inventory_id])
        )->first();

        return (bool)$result->is_in_stock;
    }

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory(): InventoryFactory
    {
        return InventoryFactory::new();
    }
}
