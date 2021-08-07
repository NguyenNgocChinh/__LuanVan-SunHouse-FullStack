<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
            $table->integer('id', true);
            $table->mediumInteger('user_id');
            $table->string('tieude',100);
            $table->text('noidung');
            $table->smallInteger('loai_id');
            $table->double('gia', 8, 2);
            $table->string('huong',20);/**/
            $table->boolean('trangthai')->default(1);
            $table->boolean('isChoThue');
            $table->char('sophongngu',2)->default(0);
            $table->char('sophongtam',2)->default(0);
            $table->char('namxaydung',4)->nullable();
            $table->string('diachi',150);
            $table->double('toadoX');
            $table->double('toadoY');
            $table->boolean('choduyet');
            $table->double('dientich',8,2);
            $table->float('douutien')->default(0);
            $table->timestamp('next_push')->nullable();
            $table->smallInteger('luotxem')->default(0);
            $table->integer('duong_id')->nullable();
            $table->softDeletes();

            $table->foreign('loai_id')->references('id')->on('loai');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('duong_id')->references('id')->on('duong');
            // DB::statement('ALTER TABLE baidang ADD FULLTEXT `diachi` (`diachi`)');
            // DB::statement('ALTER TABLE baidang ADD FULLTEXT `tieude` (`tieude`,`diachi`)');
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
        // Schema::table('baidang', function (Blueprint $table) {
        //     DB::statement('ALTER TABLE baidang DROP INDEX diachi');
        //     DB::statement('ALTER TABLE baidang DROP INDEX tieude');
        // });
        Schema::dropIfExists('baidang');
        Schema::table('baidang', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
}
