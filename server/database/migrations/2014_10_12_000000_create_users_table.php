<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->mediumInteger('id', true);
            $table->string('username', 30)->nullable()->unique();
            $table->string('name',30);
            $table->string('email',64)->unique();
            $table->char('sdt',10)->nullable()->unique();
            $table->boolean('trangthai')->default(1);
            $table->enum('vaitro', ['user', 'admin'])->default('user');
            $table->string('password', 100);
            $table->string('diachi',150)->nullable();
            $table->date('namsinh')->nullable();
            $table->string('profile_photo_path', 200)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->char('sao',1)->default(5);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
