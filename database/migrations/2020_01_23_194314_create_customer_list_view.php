<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateCustomerListView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
            CREATE VIEW `customer_list`
            AS
            SELECT
                cu.customer_id AS ID,
                CONCAT(cu.first_name, _utf8\' \', cu.last_name) AS name,
                a.address AS address,
                a.postal_code AS `zip code`,
                a.phone AS phone,
                a.city AS city,
                a.country AS country,
                IF(cu.active, _utf8\'active\',_utf8\'\') AS notes,
                cu.store_id AS SID
            FROM customer AS cu
            JOIN address AS a
                ON cu.address_id = a.address_id
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP VIEW IF EXISTS `customer_list`');
    }
}
