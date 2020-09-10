<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateActorInfoView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
            CREATE OR REPLACE DEFINER=CURRENT_USER SQL SECURITY INVOKER VIEW `actor_info`
            AS
            SELECT
                a.actor_id,
                a.first_name,
                a.last_name,
                GROUP_CONCAT(DISTINCT CONCAT(c.name, \': \',
		        (SELECT GROUP_CONCAT(f.title ORDER BY f.title SEPARATOR \', \')
                        FROM film f
                        INNER JOIN film_category fc
                            ON f.film_id = fc.film_id
                        INNER JOIN film_actor fa
                            ON f.film_id = fa.film_id
                        WHERE fc.category_id = c.category_id
                        AND fa.actor_id = a.actor_id
                    )
                )
                ORDER BY c.name SEPARATOR \'; \')
            AS film_info
            FROM actor a
            LEFT JOIN film_actor fa
                ON a.actor_id = fa.actor_id
            LEFT JOIN film_category fc
                ON fa.film_id = fc.film_id
            LEFT JOIN category c
                ON fc.category_id = c.category_id
            GROUP BY a.actor_id, a.first_name, a.last_name
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP VIEW IF EXISTS `actor_info`');
    }
}
