<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staff', function (Blueprint $table) {
            $table->tinyIncrements('staff_id');
            $table->string('first_name', 45);
            $table->string('last_name', 45);
            $table->unsignedSmallInteger('address_id');
            $table->binary('picture')->nullable();
            $table->string('email', 50)->nullable();
            $table->unsignedTinyInteger('store_id');
            $table->boolean('active')->default(true);
            $table->string('username', 16);
            $table->string('password', 40)->nullable();
            $table->timestamps();

            $table->foreign('address_id')->references('address_id')->on('address');
            $table->foreign('store_id')->references('store_id')->on('store');
        });

        Schema::table('store', function (Blueprint $table) {
            $table->unsignedTinyInteger('manager_staff_id')->after('store_id');

            $table->foreign('manager_staff_id')->references('staff_id')->on('staff');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('store', 'manager_staff_id')) {
            Schema::table('store', function (Blueprint $table) {
                $table->dropColumn('manager_staff_id');
            });
        }

        Schema::dropIfExists('staff');
    }
}
