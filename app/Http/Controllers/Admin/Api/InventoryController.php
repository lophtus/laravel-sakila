<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Http\Filters\FilterContainsMultipleFields;
use App\Http\Resources\InventoryCollection;
use App\Http\Resources\InventoryResource;
use App\Sakila\Film;
use App\Sakila\Inventory;
use App\Sakila\Store;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new InventoryCollection(
            QueryBuilder::for(Inventory::class)
                ->join('film', 'inventory.film_id', 'film.film_id')
                ->allowedIncludes(['film', 'store'])
                ->allowedFilters([
                    AllowedFilter::partial('title', 'film.title'),
                    AllowedFilter::partial('description', 'film.description'),
                    AllowedFilter::partial('release_year', 'film.release_year'),
                    AllowedFilter::partial('rating', 'film.rating'),
                    AllowedFilter::custom(
                        'search',
                        new FilterContainsMultipleFields([
                            'film.title',
                            'film.description',
                            'film.release_year',
                        ])
                    ),
                ])
                ->jsonPaginate()
        );
    }

    /**
     * Display a listing of the resource by film.
     *
     * @param Film $film
     * @return \Illuminate\Http\Response
     */
    public function indexByFilm(Film $film)
    {
        return new InventoryCollection(
            QueryBuilder::for(Inventory::class)
                ->where('film_id', $film->film_id)
                ->allowedIncludes(['film', 'store'])
                ->jsonPaginate()
        );
    }

    /**
     * Display a listing of the resource by store.
     *
     * @param Store $store
     * @return \Illuminate\Http\Response
     */
    public function indexByStore(Store $store)
    {
        return new InventoryCollection(
            QueryBuilder::for(Inventory::class)
                ->join('film', 'inventory.film_id', 'film.film_id')
                ->where('store_id', $store->store_id)
                ->allowedIncludes(['film', 'store'])
                ->allowedFilters([
                    AllowedFilter::partial('title', 'film.title'),
                    AllowedFilter::partial('description', 'film.description'),
                    AllowedFilter::partial('release_year', 'film.release_year'),
                    AllowedFilter::partial('rating', 'film.rating'),
                    AllowedFilter::custom(
                        'search',
                        new FilterContainsMultipleFields([
                            'film.title',
                            'film.description',
                            'film.release_year',
                        ])
                    ),
                ])
                ->jsonPaginate()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $inventory = QueryBuilder::for(Inventory::class)
            ->allowedIncludes(['film', 'store'])
            ->find($id);

        if (! $inventory) {
            abort(404);
        }

        return new InventoryResource($inventory);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $inventory = QueryBuilder::for(Inventory::class)
            ->find($id);

        if (! $inventory) {
            abort(404);
        }

        $inventory->delete();

        return new InventoryResource($inventory);
    }
}
