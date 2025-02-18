<?php

namespace App\Sakila;

use Database\Factories\FilmFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    use HasFactory;

    /**
     * @OA\Schema(
     *   schema="Rating",
     *   type="string",
     *   nullable=true,
     *   enum={
     *     "G",
     *     "PG",
     *     "PG-13",
     *     "R",
     *     "NC-17",
     *   }
     * )
     *
     * @var array
     */
    public const RATINGS = [
        'G',
        'PG',
        'PG-13',
        'R',
        'NC-17'
    ];

    /**
     * @OA\Schema(
     *   schema="SpecialFeatures",
     *   type="string",
     *   nullable=true,
     *   enum={
     *     "Trailers",
     *     "Commentaries",
     *     "Deleted Scenes",
     *     "Behind the Scenes",
     *   }
     * )
     *
     * @var array
     */
    public const SPECIAL_FEATURES = [
        'Trailers',
        'Commentaries',
        'Deleted Scenes',
        'Behind the Scenes'
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'film';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'film_id';

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'language_id' => 1,
        'rental_duration' => 3,
        'rental_rate' => 4.99,
        'replacement_cost' => 19.99,
        'rating' => 'G',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'release_year',
        'language_id',
        'rental_duration',
        'rental_rate',
        'length',
        'replacement_cost',
        'rating',
        'special_features',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'release_year' => 'integer',
        'rental_rate' => 'float',
        'length' => 'integer',
        'replacement_cost' => 'float',
    ];

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = [
        'language',
        'originalLanguage',
    ];

    /**
     * Returns a collection of associated actors
     *
     * @return Collection<Actor>
     */
    public function actors()
    {
        return $this->belongsToMany(Actor::class, 'film_actor', 'film_id', 'actor_id', 'film_id', 'actor_id')->withTimestamps();
    }

    /**
     * Returns a collection of associated categories
     *
     * @return Collection<Category>
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'film_category', 'film_id', 'category_id', 'film_id', 'category_id')->withTimestamps();
    }

    /**
     * Returns the associated language
     *
     * @return Language
     */
    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id', 'language_id');
    }

    /**
     * Returns the associated original language if defined; otherwise null
     *
     * @return Language|null
     */
    public function originalLanguage()
    {
        return $this->belongsTo(Language::class, 'original_language_id', 'language_id');
    }

    /**
     * Returns the associated store inventory
     *
     * @return Collection<Inventory>
     */
    public function inventory()
    {
        return $this->hasMany(Inventory::class, 'film_id', 'film_id');
    }

    /**
     * Returns the associated store inventory
     *
     * @return Collection<Inventory>
     */
    public function inStockInventory()
    {
        return $this->inventory()->whereRaw('inventory_in_stock(inventory.inventory_id)');
    }

    /**
     * Returns a collection of associated stores from inventory
     *
     * @return Collection<Store>
     */
    public function stores()
    {
        return $this->hasManyThrough(Store::class, Inventory::class, 'film_id', 'store_id', 'film_id', 'store_id');
    }

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory(): FilmFactory
    {
        return FilmFactory::new();
    }
}
