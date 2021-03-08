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
            $table->id();
            $table->string('username')->nullable()->unique();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('sdt')->nullable();
            $table->boolean('trangthai')->default(1);
            $table->enum('vaitro', ['user', 'seller', 'admin'])->default('user');
            $table->string('password');
            $table->string('diachi')->nullable();
            $table->date('namsinh')->nullable();
            $table->text('profile_photo_path')->nullable();
            $table->rememberToken();
            $table->timestamp('email_verified_at')->nullable();
            $table->enum('provideID',['google','facebook'])->nullable();
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
