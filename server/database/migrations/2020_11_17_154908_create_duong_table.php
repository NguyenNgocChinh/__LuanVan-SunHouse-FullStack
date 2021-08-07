<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDuongTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('duong', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('xaid', 5);
            // $table->integer('baidang_id');
            $table->string('tenduong');
            $table->boolean('choduyet')->default(true);

            $table->foreign('xaid')->references('xaid')->on('xaphuongthitran');
            // $table->foreign('baidang_id')->references('id')->on('baidang');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('duong');
    }
}
