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
            $table->increments('id');
            $table->string('name');
            $table->string('user_name')->unique();
            $table->string('phone')->unique();
            $table->string('email')->nullable();
            $table->string('nid')->nullable();
            $table->string('profile_pic')->nullable();
            $table->integer('user_type');//admin=1, Agent=2, Supplier=3, Supplier Operator =4, Moderator=5
            $table->string('password');
            $table->unsignedBigInteger('district_id')->nullable();
            $table->boolean('is_active')->default(true);
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
