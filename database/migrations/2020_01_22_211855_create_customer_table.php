<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer', function (Blueprint $table) {
            $table->smallIncrements('customer_id');
            $table->unsignedTinyInteger('store_id');
            $table->string('first_name', 45);
            $table->string('last_name', 45);
            $table->string('email', 50)->nullable();
            $table->unsignedSmallInteger('address_id');
            $table->boolean('active')->default(true);
            $table->timestamps();

            $table->foreign('store_id')->references('store_id')->on('store');
            $table->foreign('address_id')->references('address_id')->on('address');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer');
    }
}
