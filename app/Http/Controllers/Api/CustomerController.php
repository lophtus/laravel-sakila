<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryCollection;
use App\Sakila\Category;
use Illuminate\Support\Facades\Cache;

class CustomerController extends Controller
{
    /**
     * Display a list of suggestions for the customer
     *
     * @return \Illuminate\Http\Response
     */
    public function getSuggestions()
    {
        $ttl = 60; // seconds

        $categories = Cache::remember('customer_suggestions', $ttl, function () {
            return Category::inRandomOrder()
                ->orderBy('name')
                ->take(5)
                ->get()
                ->sortBy(function ($model) {
                     return $model->name;
                })
                ->values()
                ->each(function ($category) {
                    $category->load(['films' => function ($query) {
                        $query->inRandomOrder()->take(10);
                    }]);
                });
        });

        return new CategoryCollection($categories);
    }
}
