<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment', function (Blueprint $table) {
            $table->smallIncrements('payment_id');
            $table->unsignedSmallInteger('customer_id');
            $table->unsignedTinyInteger('staff_id');
            $table->unsignedInteger('rental_id')->nullable();
            $table->decimal('amount', 5, 2);
            $table->dateTime('payment_date');
            $table->timestamps();

            $table->foreign('customer_id')->references('customer_id')->on('customer');
            $table->foreign('staff_id')->references('staff_id')->on('staff');
            $table->foreign('rental_id')->references('rental_id')->on('rental');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment');
    }
}
