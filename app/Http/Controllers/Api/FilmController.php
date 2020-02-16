<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFilmRequest;
use App\Http\Requests\UpdateFilmRequest;
use App\Http\Resources\FilmCollection;
use App\Http\Resources\FilmResource;
use App\Sakila\Film;
use App\Sakila\Store;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\QueryBuilder;

class FilmController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new FilmCollection(
            QueryBuilder::for(Film::class)
                ->allowedFilters(['title', 'description', 'release_year', 'rating'])
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
        return new FilmCollection(
            QueryBuilder::for(Film::class)
                ->whereHas('stores', function (Builder $query ) use ($store) {
                    $query->where('store.store_id', $store->store_id);
                })
                ->allowedFilters(['title', 'description', 'release_year', 'rating'])
                ->jsonPaginate()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreFilmRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFilmRequest $request)
    {
        $film = new Film();
        $film->fill($request->all());
        $film->save();

        return new FilmResource($film);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $film = Film::find($id);

        if (! $film) {
            abort(404);
        }

        return new FilmResource($film);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateFilmRequest $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFilmRequest $request, $id)
    {
        $film = Film::find($id);

        if (! $film) {
            abort(404);
        }

        $film->fill($request->all());
        $film->save();

        return new FilmResource($film->refresh());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $film = Film::find($id);

        if (! $film) {
            abort(404);
        }

        $film->delete();

        return new FilmResource($film);
    }
}
