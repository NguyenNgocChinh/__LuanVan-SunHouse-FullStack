<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableQuanhuyen extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quanhuyen', function (Blueprint $table) {
            $table->string('maqh', 5)->primary();
            $table->string('name', 100);
            $table->string('type', 30);
            $table->string('matp', 5);

            $table->foreign('matp')->references('matp')->on('tinhthanhpho');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quanhuyen');
    }
}
