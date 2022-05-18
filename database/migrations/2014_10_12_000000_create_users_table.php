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
            $table->string('name');
            $table->string('email')->unique();
            $table->string('user_name')->unique();
            $table->string('contact')->unique();
            $table->enum('user_role', ['root', 'admin', 'supervisor', 'guest'])->default('guest');
            $table->enum('user_status', [0, 1])->default(0);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('image_path')->nullable();
            $table->string('token', 64)->unique();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
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
