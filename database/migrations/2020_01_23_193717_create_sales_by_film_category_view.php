<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateSalesByFilmCategoryView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
            CREATE VIEW `sales_by_film_category`
            AS
            SELECT
                c.name AS category,
                SUM(p.amount) AS total_sales
            FROM payment AS p
            INNER JOIN rental AS r ON p.rental_id = r.rental_id
            INNER JOIN inventory AS i ON r.inventory_id = i.inventory_id
            INNER JOIN film AS f ON i.film_id = f.film_id
            INNER JOIN film_category AS fc ON f.film_id = fc.film_id
            INNER JOIN category AS c ON fc.category_id = c.category_id
            GROUP BY c.name
            ORDER BY total_sales DESC
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP VIEW IF EXISTS `sales_by_film_category`');
    }
}
