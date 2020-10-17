<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RentalResource;
use App\Sakila\Customer;
use App\Sakila\Film;
use App\Sakila\Inventory;
use App\Sakila\Rental;
use App\Sakila\Store;
use DateTime;
use Illuminate\Database\Eloquent\Builder;

class RentalController extends Controller
{
    /**
     * Rent a film from the specified store
     *
     * @param Store $store
     * @param Film $film
     * @return RentalResource
     */
    public function store(Store $store, Film $film)
    {
        // check if film is available from store
        $inventory = Inventory::whereHas('store', function (Builder $query) use ($store) {
                return $query->where('store_id', $store->store_id);
        })
            ->whereHas('film', function (Builder $query) use ($film) {
                return $query->where('film_id', $film->film_id);
            })
            ->get()
            ->first(function ($item, $key) {
                // check if inventory is in stock
                return $item->isInStock();
            });

        if (! $inventory) {
            abort(409, "Rental not available, try again later.");
        }

        $customer = Customer::first(); // this should be the authenticated customer

        $rental = new Rental();
        $rental->inventory()->associate($inventory);
        $rental->customer()->associate($customer);
        $rental->rental_date = new DateTime('now');
        $rental->save();

        return new RentalResource($rental);
    }
}
