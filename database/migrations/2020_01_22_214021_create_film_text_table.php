<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateFilmTextTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('film_text', function (Blueprint $table) {
            $table->unsignedInteger('film_id')->primary();
            $table->string('title', 255);
            $table->text('description')->nullable();

            $table->foreign('film_id')->references('film_id')->on('film');
        });

        DB::unprepared('
            CREATE TRIGGER `ins_film` AFTER INSERT ON `film` FOR EACH ROW BEGIN
                INSERT INTO film_text (film_id, title, description)
                    VALUES (new.film_id, new.title, new.description);
            END
        ');

        DB::unprepared('
            CREATE TRIGGER `upd_film` AFTER UPDATE ON `film` FOR EACH ROW BEGIN
                IF (old.title != new.title) or (old.description != new.description)
                THEN
                    UPDATE film_text
                       SET title=new.title,
                           description=new.description,
                           film_id=new.film_id
                   WHERE film_id=old.film_id;
                END IF;
            END
        ');

        DB::unprepared('
            CREATE TRIGGER `del_film` AFTER DELETE ON `film` FOR EACH ROW BEGIN
                DELETE FROM film_text WHERE film_id = old.film_id;
            END
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER IF EXISTS `del_film`');
        DB::unprepared('DROP TRIGGER IF EXISTS `upd_film`');
        DB::unprepared('DROP TRIGGER IF EXISTS `ins_film`');

        Schema::dropIfExists('film_text');
    }
}
