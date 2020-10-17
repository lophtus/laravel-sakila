<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AuthRequest;
use App\Http\Resources\Auth\AuthResource;
use App\Sakila\Customer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * Attempts to login a user
     *
     * @param AuthRequest $request
     * @return \Illuminate\Http\Response
     */
    public function login(AuthRequest $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        if (! Auth::attempt(['email' => $email, 'password' => $password, 'active' => 1])) {
            return response()
                ->json(['message' => 'Email or password is incorrect'])
                ->setStatusCode(422);
        }

        $customer = Customer::with('store')->whereEmail($email)->firstOrFail();

        $customer->access_token = Str::random(60);
        $customer->save();

        return new AuthResource($customer);
    }
}
