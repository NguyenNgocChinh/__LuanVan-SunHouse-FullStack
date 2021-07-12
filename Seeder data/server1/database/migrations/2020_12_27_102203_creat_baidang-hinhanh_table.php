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
            $table->id();
            //$table->unsignedBigInteger('baidang_id');
            $table->foreignId('baidang_id')->references('id')->on('baidang');

            $table->string('filename');
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
