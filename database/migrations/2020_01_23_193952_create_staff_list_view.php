<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateStaffListView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
            CREATE VIEW `staff_list`
            AS
            SELECT
                s.staff_id AS ID,
                CONCAT(s.first_name, _utf8\' \', s.last_name) AS name,
                a.address AS address,
                a.postal_code AS `zip code`,
                a.phone AS phone,
                city.city AS city,
                country.country AS country,
                s.store_id AS SID
            FROM staff AS s
            JOIN address AS a
                ON s.address_id = a.address_id
            JOIN city
                ON a.city_id = city.city_id
            JOIN country
                ON city.country_id = country.country_id
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP VIEW IF EXISTS `staff_list`');
    }
}
