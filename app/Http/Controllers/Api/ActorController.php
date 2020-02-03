<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreActorRequest;
use App\Http\Requests\UpdateActorRequest;
use App\Http\Resources\ActorCollection;
use App\Http\Resources\ActorResource;
use App\Sakila\Actor;
use Spatie\QueryBuilder\QueryBuilder;

class ActorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new ActorCollection(
            QueryBuilder::for(Actor::class)
                ->allowedFilters(['first_name', 'last_name'])
                ->jsonPaginate()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreActorRequest $request)
    {
        $actor = new Actor();
        $actor->fill($request->all());
        $actor->save();

        return new ActorResource($actor);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $actor = Actor::find($id);

        if (! $actor) {
            abort(404);
        }

        return new ActorResource($actor);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateActorRequest $request, $id)
    {
        $actor = Actor::find($id);

        if (! $actor) {
            abort(404);
        }

        $actor->fill($request->all());
        $actor->save();

        return $actor->refresh();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $actor = Actor::find($id);

        if (! $actor) {
            abort(404);
        }

        $actor->delete();

        return new ActorResource($actor);
    }
}
