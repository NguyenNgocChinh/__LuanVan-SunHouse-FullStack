<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateLocationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        DB::statement("
            CREATE TABLE IF NOT EXISTS location (
              id int(11) NOT NULL AUTO_INCREMENT,
              baidang_id int(11) NOT NULL,
              position point NOT NULL,
              trangthai tinyint(1) DEFAULT 1,
              PRIMARY KEY (id),
              SPATIAL KEY position (position),
              INDEX INDEX_POSITION (position)
            ) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('location');
    }
}
