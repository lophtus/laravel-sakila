<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilmActorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('film_actor', function (Blueprint $table) {
            $table->unsignedSmallInteger('actor_id');
            $table->unsignedInteger('film_id');
            $table->timestamps();

            $table->primary(['actor_id', 'film_id']);

            $table->foreign('actor_id')->references('actor_id')->on('actor');
            $table->foreign('film_id')->references('film_id')->on('film');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('film_actor');
    }
}
