<?php

namespace App\Sakila;

use Database\Factories\ActorFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Actor extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'actor';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'actor_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
    ];

    /**
     * Returns a collection of associated films
     *
     * @return Collection<Film>
     */
    public function films()
    {
        return $this->belongsToMany(Film::class);
    }

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory(): ActorFactory
    {
        return ActorFactory::new();
    }
}
