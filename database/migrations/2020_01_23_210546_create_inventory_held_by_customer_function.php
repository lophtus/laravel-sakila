<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateInventoryHeldByCustomerFunction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
            CREATE FUNCTION `inventory_held_by_customer`(p_inventory_id INT) RETURNS INT
                READS SQL DATA
            BEGIN
                DECLARE v_customer_id INT;
                DECLARE EXIT HANDLER FOR NOT FOUND RETURN NULL;

                SELECT customer_id INTO v_customer_id
                FROM rental
                WHERE return_date IS NULL
                    AND inventory_id = p_inventory_id;

                RETURN v_customer_id;
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
        DB::unprepared('DROP FUNCTION IF EXISTS `inventory_held_by_customer`');
    }
}
