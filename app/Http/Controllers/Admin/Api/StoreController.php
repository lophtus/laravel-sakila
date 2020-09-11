<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Http\DTOs\StoreData;
use App\Http\Requests\StoreStoreRequest;
use App\Http\Requests\UpdateStoreRequest;
use App\Http\Resources\StoreCollection;
use App\Http\Resources\StoreResource;
use App\Sakila\Film;
use App\Sakila\Store;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\QueryBuilder;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new StoreCollection(
            QueryBuilder::for(Store::class)
                ->allowedFilters([])
                ->jsonPaginate()
        );
    }

    /**
     * Display a listing of the resource by film.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexByFilm(Film $film)
    {
        return new StoreCollection(
            QueryBuilder::for(Store::class)
                ->whereHas('films', function (Builder $query) use ($film) {
                    $query->where('film.film_id', $film->film_id);
                })
                ->allowedFilters([])
                ->jsonPaginate()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStoreRequest $request)
    {
        $store = new Store();
        $store->fill(StoreData::fromRequest($request));
        $store->push();

        return new StoreResource($store->refresh());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $store = Store::find($id);

        if (! $store) {
            abort(404);
        }

        return new StoreResource($store);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateStoreRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateStoreRequest $request, $id)
    {
        $store = Store::find($id);

        if (! $store) {
            abort(404);
        }

        $store->fill(StoreData::fromRequest($request));
        $store->push();

        return new StoreResource($store->refresh());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $store = Store::find($id);

        if (! $store) {
            abort(404);
        }

        $store->delete();

        return new StoreResource($store);
    }
}
