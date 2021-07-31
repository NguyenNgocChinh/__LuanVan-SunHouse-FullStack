<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableTiennghiBaidang extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tiennghi-baidang', function (Blueprint $table) {
            $table->integer('id', true);
            $table->smallInteger('tiennghi_id');/**/
            $table->integer('baidang_id');

            $table->foreign('baidang_id')->references('id')->on('baidang');
            $table->foreign('tiennghi_id')->references('id')->on('tiennghi');/**/
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tiennghi-baidang');
    }
}
