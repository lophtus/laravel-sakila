<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateSalesByStoreView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
            CREATE OR REPLACE VIEW `sales_by_store`
            AS
            SELECT
                CONCAT(a.city, _utf8\',\', a.country) AS store,
                CONCAT(m.first_name, _utf8\' \', m.last_name) AS manager,
                SUM(p.amount) AS total_sales
            FROM payment AS p
            INNER JOIN rental AS r ON p.rental_id = r.rental_id
            INNER JOIN inventory AS i ON r.inventory_id = i.inventory_id
            INNER JOIN store AS s ON i.store_id = s.store_id
            INNER JOIN address AS a ON s.address_id = a.address_id
            INNER JOIN staff AS m ON s.manager_staff_id = m.staff_id
            GROUP BY s.store_id
            ORDER BY a.country, a.city
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP VIEW IF EXISTS `sales_by_store`');
    }
}
