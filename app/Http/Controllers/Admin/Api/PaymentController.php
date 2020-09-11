<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PaymentCollection;
use App\Http\Resources\PaymentResource;
use App\Sakila\Customer;
use App\Sakila\Payment;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\QueryBuilder;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new PaymentCollection(
            QueryBuilder::for(Payment::class)
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
        return new PaymentCollection(
            QueryBuilder::for(Payment::class)
                ->whereHas('customer', function (Builder $query)  use ($customer) {
                    $query->where('customer.customer_id', $customer->customer_id);
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
        $payment = Payment::find($id);

        if (! $payment) {
            abort(404);
        }

        return new PaymentResource($payment);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $payment = Payment::find($id);

        if (! $payment) {
            abort(404);
        }

        $payment->delete();

        return new PaymentResource($payment);
    }
}
