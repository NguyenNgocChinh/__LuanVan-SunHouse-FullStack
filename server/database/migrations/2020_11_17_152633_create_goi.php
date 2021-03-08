<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGoi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goi', function (Blueprint $table) {
            $table->id();
            $table->string('ten');
            $table->double('gia', 8, 2);
            $table->integer('douutien');
            $table->integer('slbaidang');
            $table->float('hansudung', 8, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('goi');
    }
}
