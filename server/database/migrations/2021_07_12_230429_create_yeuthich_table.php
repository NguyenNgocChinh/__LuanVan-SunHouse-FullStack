<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateYeuthichTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('yeuthich', function (Blueprint $table) {
            $table->integer('id',true);
            $table->integer('baidang_id');
            $table->mediumInteger('user_id');

            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('yeuthich');
    }
}
