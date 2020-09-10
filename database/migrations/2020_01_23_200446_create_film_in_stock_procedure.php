<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateFilmInStockProcedure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS `film_in_stock`');

        DB::unprepared('
            CREATE PROCEDURE `film_in_stock`(IN p_film_id INT, IN p_store_id INT, OUT p_film_count INT)
            READS SQL DATA
            BEGIN
                SELECT inventory_id
                FROM inventory
                WHERE film_id = p_film_id
                    AND store_id = p_store_id
                    AND inventory_in_stock(inventory_id);

                SELECT FOUND_ROWS() INTO p_film_count;
            END;
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS `film_in_stock`');
    }
}
