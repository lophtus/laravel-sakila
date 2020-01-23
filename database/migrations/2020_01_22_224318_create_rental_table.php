<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRentalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rental', function (Blueprint $table) {
            $table->increments('rental_id');
            $table->dateTime('rental_date');
            $table->unsignedMediumInteger('inventory_id');
            $table->unsignedSmallInteger('customer_id');
            $table->dateTime('return_date')->nullable();
            $table->unsignedTinyInteger('staff_id');
            $table->timestamps();

            $table->foreign('inventory_id')->references('inventory_id')->on('inventory');
            $table->foreign('customer_id')->references('customer_id')->on('customer');
            $table->foreign('staff_id')->references('staff_id')->on('staff');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rental');
    }
}
