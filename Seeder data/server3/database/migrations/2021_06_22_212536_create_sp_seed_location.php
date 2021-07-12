<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateSpSeedLocation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("
            CREATE PROCEDURE sp_seed_location ()
            BEGIN
                SET @v1 = 0;
                WHILE @v1 < 1000000
                    DO
                    SET @v1 = @v1 + 1;
                    SET @baidang_id = @v1;
                    SET @toadoX :=  ROUND(RAND() * (109.27-105.18) + 105.18, 4);
                    SET @toadoY :=  ROUND(RAND() * (23.21-8.37) + 8.37, 4);
                    set @position = ST_GeomFromText(CONCAT('point(',@toadoX,' ',@toadoY, ')'),4326);
                    select ST_AsText(@position);
                    insert into location
                        (baidang_id, position)
                        values
                        (@baidang_id, @position);
                END WHILE;
            END

        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_seed_location');
    }
}
