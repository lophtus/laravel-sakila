<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryResource;
use App\Sakila\Category;
use Spatie\QueryBuilder\QueryBuilder;

class CategoryController extends Controller
{
   /**
     * Display a listing of categories.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new CategoryCollection(
            QueryBuilder::for(Category::class)
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
        $category = QueryBuilder::for(Category::class)
            ->allowedIncludes(['films'])
            ->find($id);

        if (! $category) {
            abort(404);
        }

        return new CategoryResource($category);
    }
}
