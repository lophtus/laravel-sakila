<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilmTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('film', function (Blueprint $table) {
            $table->increments('film_id');
            $table->string('title', 255);
            $table->text('description')->nullable();
            $table->unsignedSmallInteger('release_year')->nullable();
            $table->unsignedTinyInteger('language_id');
            $table->unsignedTinyInteger('original_language_id')->nullable();
            $table->tinyInteger('rental_duration')->default(3);
            $table->decimal('rental_rate', 4, 2)->default(4.99);
            $table->unsignedSmallInteger('length')->nullable();
            $table->decimal('replacement_cost', 5, 2)->default(19.99);
            $table->enum('rating', ['G', 'PG', 'PG-13', 'R', 'NC-17'])->default('G')->nullable();
            $table->set('special_features', ['Trailers', 'Commentaries','Deleted Scenes','Behind the Scenes'])->nullable();
            $table->timestamps();

            $table->foreign('language_id')->references('language_id')->on('language');
            $table->foreign('original_language_id')->references('language_id')->on('language');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('film');
    }
}
