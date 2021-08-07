<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBaoCaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('baocao', function (Blueprint $table) {
            $table->integer('id',true);
            $table->mediumInteger('user_id');
            $table->mediumInteger('user_bibaocao');
            $table->integer('baidang_id');
            $table->string('noidung',255);
            $table->timestamps();

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
        Schema::dropIfExists('baocao');
    }
}
