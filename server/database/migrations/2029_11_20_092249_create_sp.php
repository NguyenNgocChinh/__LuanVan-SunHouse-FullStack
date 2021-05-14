<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateSp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
            DROP PROCEDURE IF EXISTS popup_bando;

            CREATE PROCEDURE popup_bando()
            select baidang.id,loai.ten_loai,baidang.tieude,baidang.diachi,baidang.sophongngu,baidang.sophongtam,baidang.dientich,toadoX,toadoY,baidang.isChoThue
            from baidang
            join loai
            on loai.id = baidang.loai_id
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS popup_bando');
    }
}
