<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory', function (Blueprint $table) {
            $table->mediumIncrements('inventory_id');
            $table->unsignedSmallInteger('film_id');
            $table->unsignedTinyInteger('store_id');
            $table->timestamps();

            $table->foreign('film_id')->references('film_id')->on('film');
            $table->foreign('store_id')->references('store_id')->on('store');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventory');
    }
}
