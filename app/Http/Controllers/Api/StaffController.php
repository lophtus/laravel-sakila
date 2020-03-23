<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\DTOs\StaffData;
use App\Http\Filters\FilterContainsMultipleFields;
use App\Http\Requests\StoreStaffRequest;
use App\Http\Requests\UpdateStaffRequest;
use App\Http\Resources\StaffCollection;
use App\Http\Resources\StaffResource;
use App\Sakila\Staff;
use App\Sakila\Store;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new StaffCollection(
            QueryBuilder::for(Staff::class)
                ->allowedFilters([
                    'first_name',
                    'last_name',
                    'email',
                    'username',
                    AllowedFilter::custom(
                        'search',
                        new FilterContainsMultipleFields([
                            'first_name',
                            'last_name',
                            'email',
                            'username',
                        ])
                    ),
                ])
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
        return new StaffCollection(
            QueryBuilder::for(Staff::class)
                ->where('store_id', $store->store_id)
                ->allowedFilters([
                    'first_name',
                    'last_name',
                    'email',
                    'username',
                    AllowedFilter::custom(
                        'search',
                        new FilterContainsMultipleFields([
                            'first_name',
                            'last_name',
                            'email',
                            'username',
                        ])
                    ),
                ])
                ->jsonPaginate()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreStaffRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStaffRequest $request, Store $store)
    {
        $staff = $store->staff()
            ->create(StaffData::fromRequest($request));

        return new StaffResource($staff->refresh());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $staff = QueryBuilder::for(Staff::class)
            ->find($id);

        if (! $staff) {
            abort(404);
        }

        return new StaffResource($staff);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateStaffRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateStaffRequest $request, $id)
    {
        $staff = QueryBuilder::for(Staff::class)
            ->find($id);

        if (! $staff) {
            abort(404);
        }

        $staff->fill(StaffData::fromRequest($request));
        $staff->push();

        return new StaffResource($staff->refresh());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $staff = QueryBuilder::for(Staff::class)
            ->find($id);

        if (! $staff) {
            abort(404);
        }

        $staff->delete();

        return new StaffResource($staff);
    }
}
