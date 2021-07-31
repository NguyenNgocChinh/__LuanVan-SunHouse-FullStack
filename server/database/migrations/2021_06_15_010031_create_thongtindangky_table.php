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
            $table->mediumInteger('id',true);
            $table->mediumInteger('user_id');
            $table->double('giamin')->nullable();
            $table->double('giamax')->nullable();
            $table->double('dientichmin')->nullable();
            $table->double('dientichmax')->nullable();
            $table->smallInteger('loai_id')->nullable();
            $table->char('sophongngu',2)->nullable();
            $table->char('sophongtam',2)->nullable();
            $table->boolean('isChoThue')->nullable();
            $table->string('huong',20)->nullable();
            $table->string('diachi',100)->nullable();
            $table->timestamps();

            $table->foreign('loai_id')->references('id')->on('loai');
            $table->foreign('user_id')->references('id')->on('users');
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
