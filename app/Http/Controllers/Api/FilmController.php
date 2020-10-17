<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Filters\FilterContainsMultipleFields;
use App\Http\Resources\FilmCollection;
use App\Http\Resources\FilmResource;
use App\Sakila\Category;
use App\Sakila\Film;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class FilmController extends Controller
{
    /**
     * Display a listing of films.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return new FilmCollection(
            QueryBuilder::for(Film::class)
                ->allowedFilters([
                    'title',
                    'description',
                    'release_year',
                    AllowedFilter::custom(
                        'search',
                        new FilterContainsMultipleFields([
                            'title',
                            'description',
                            'release_year',
                        ])
                    ),
                ])
                ->allowedIncludes(['actors'])
                ->jsonPaginate()
        );
    }

    /**
     * Display a listing of the resource by category.
     *
     * @param Category $category
     * @return \Illuminate\Http\Response
     */
    public function indexByCategory(Category $category)
    {
        return new FilmCollection(
            QueryBuilder::for(Film::class)
                ->whereHas('categories', function (Builder $query) use ($category) {
                    $query->where('category.category_id', $category->category_id);
                })
                ->allowedFilters([
                    AllowedFilter::custom(
                        'search',
                        new FilterContainsMultipleFields([
                            'title',
                            'description',
                            'release_year',
                        ])
                    ),
                ])
                ->allowedIncludes(['actors', 'inStockInventory.store'])
                ->jsonPaginate()
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $film = QueryBuilder::for(Film::class)
            ->allowedIncludes(['actors', 'inStockInventory.store'])
            ->find($id);

        if (! $film) {
            abort(404);
        }

        return new FilmResource($film);
    }
}
