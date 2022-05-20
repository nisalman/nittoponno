<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('shops', function (Blueprint $table) {
            $table->increments('shop_id');
            $table->unsignedInteger('user_id');
            $table->string('shop_name')->nullable();
            $table->string('shop_phone')->nullable();

            $table->string('service_type')->nullable();
            $table->integer('per_day_capacity')->default(5);

            $table->string('coverage_depth');//(Division, District, Upazila, Union)
            $table->unsignedInteger('division_id');
            $table->string('district_id')->nullable();
            $table->string('upazila_id')->nullable();
            $table->string('union_id')->nullable();

            $table->text('address')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_serve_in_depth')->default(true);
            $table->unsignedBigInteger('last_changed_by')->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shops');
    }
}
