<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\DTOs\CustomerData;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Http\Resources\CustomerCollection;
use App\Http\Resources\CustomerResource;
use App\Sakila\Customer;
use App\Sakila\Store;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\QueryBuilder;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new CustomerCollection(
            QueryBuilder::for(Customer::class)
                ->allowedFilters(['first_name', 'last_name', 'email'])
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
        return new CustomerCollection(
            QueryBuilder::for(Customer::class)
                ->whereHas('store', function (Builder $query ) use ($store) {
                    $query->where('store.store_id', $store->store_id);
                })
                ->allowedFilters(['first_name', 'last_name', 'email'])
                ->jsonPaginate()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreCustomerRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCustomerRequest $request, Store $store)
    {

        $customer = $store->customers()
            ->create(CustomerData::fromRequest($request));

        return new CustomerResource($customer->refresh());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $customer = Customer::find($id);

        if (! $customer) {
            abort(404);
        }

        return new CustomerResource($customer);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateCustomerRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCustomerRequest $request, $id)
    {
        $customer = Customer::find($id);

        if (! $customer) {
            abort(404);
        }

        $customer->fill(CustomerData::fromRequest($request));
        $customer->push();

        return new CustomerResource($customer->refresh());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer = Customer::find($id);

        if (! $customer) {
            abort(404);
        }

        $customer->delete();

        return new CustomerResource($customer);
    }
}
