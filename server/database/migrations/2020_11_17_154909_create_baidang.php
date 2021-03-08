<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBaidang extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('baidang', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('tieude');
            $table->longText('noidung');
            $table->unsignedBigInteger('loai_id');
            $table->foreign('loai_id')->references('id')->on('loai');
            $table->double('gia');
            $table->string('huong');/**/
            $table->boolean('trangthai')->default(1);
            $table->boolean('isChoThue');
            $table->integer('sophongngu')->default(0);
            $table->integer('sophongtam')->default(0);
            $table->integer('namxaydung')->useCurrent();
            $table->text('diachi');
            $table->float('toadoX');
            $table->float('toadoY');
            $table->boolean('choduyet');
            $table->double('dientich');
            $table->unsignedBigInteger('id_goi');
            $table->foreign('id_goi')->references('id')->on('goi');

            $table->nullableTimestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('baidang');
    }
}
