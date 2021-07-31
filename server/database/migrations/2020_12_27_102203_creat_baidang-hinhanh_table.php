<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatBaidangHinhanhTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('baidang-hinhanh', function (Blueprint $table) {
            $table->integer('id',true);
            $table->integer('baidang_id');
            $table->string('filename');

            $table->foreign('baidang_id')->references('id')->on('baidang');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('baidang-hinhanh');
    }
}
