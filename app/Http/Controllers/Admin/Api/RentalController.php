<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RentalCollection;
use App\Http\Resources\RentalResource;
use App\Sakila\Customer;
use App\Sakila\Rental;
use App\Sakila\Store;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\QueryBuilder;

class RentalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new RentalCollection(
            QueryBuilder::for(Rental::class)
                ->jsonPaginate()
        );
    }

    /**
     * Display a listing of the resource by customer.
     *
     * @param Customer $customer
     * @return \Illuminate\Http\Response
     */
    public function indexByCustomer(Customer $customer)
    {
        return new RentalCollection(
            QueryBuilder::for(Rental::class)
                ->whereHas('customer', function (Builder $query) use ($customer) {
                    $query->where('customer.customer_id', $customer->customer_id);
                })
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
        return new RentalCollection(
            QueryBuilder::for(Rental::class)
                ->whereHas('store', function (Builder $query) use ($store) {
                    $query->where('store.store_id', $store->store_id);
                })
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
        $rental = Rental::find($id);

        if (! $rental) {
            abort(404);
        }

        return new RentalResource($rental);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $rental = Rental::find($id);

        if (! $rental) {
            abort(404);
        }

        $rental->delete();

        return new RentalResource($rental);
    }
}
