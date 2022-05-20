<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

/*        invoice_number
is_duplicate
time*/
        Schema::create('order_datas', function (Blueprint $table) {
            $table->increments('order_id');
            $table->string('invoice_number')->nullable();
            $table->string('name')->nullable();
            $table->string('phone')->nullable();
            $table->string('delivery_address')->nullable();
            $table->string('service_type');
            $table->string('image')->nullable();
            $table->string('time')->nullable();


            $table->unsignedInteger('status')->default(1);

            $table->unsignedInteger('division_id')->nullable();
            $table->unsignedInteger('district_id')->nullable();
            $table->unsignedInteger('upazila_id')->nullable();
            $table->unsignedInteger('union_id')->nullable();

            $table->text('product_list')->nullable();
            $table->text('admin_remarks')->nullable();
            $table->text('supplier_remarks')->nullable();
            $table->unsignedInteger('shop_id')->nullable();//Assign Supplier
            $table->unsignedInteger('delivery_man_id')->nullable();//Assign by Supplier
            $table->unsignedInteger('updated_by')->nullable();//Operator ID
            $table->boolean('is_from_public')->default(false);

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
        Schema::dropIfExists('order_datas');
    }
}
