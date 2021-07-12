<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThongtindangkyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('thongtindangky', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->double('giamin')->nullable();
            $table->double('giamax')->nullable();
            $table->double('dientichmin')->nullable();
            $table->double('dientichmax')->nullable();
            $table->unsignedBigInteger('loai_id')->nullable();
            $table->foreign('loai_id')->references('id')->on('loai');
            $table->integer('sophongngu')->nullable();
            $table->integer('sophongtam')->nullable();
            $table->boolean('isChoThue')->nullable();
            $table->string('huong')->nullable();
            $table->text('diachi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('thongtindangky');
    }
}
