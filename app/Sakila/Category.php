<?php

namespace App\Sakila;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'category';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'category_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Returns a collection of associated films
     *
     * @return Collection<Film>
     */
    public function films()
    {
        return $this->belongsToMany(Film::class)->withTimestamps();
    }
}
