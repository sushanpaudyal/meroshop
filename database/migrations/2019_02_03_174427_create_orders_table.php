<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('user_email');
            $table->string('name');
            $table->string('address');
            $table->string('city');
            $table->string('state');
            $table->string('pincodee');
            $table->string('country');
            $table->string('mobile');
            $table->float('shipping_charges', 8, 2);
            $table->string('coupon_code');
            $table->float('coupon_amount', 8 , 2);
            $table->string('order_status');
            $table->string('payment_method');
            $table->float('grand_total', 8, 2);


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
        Schema::dropIfExists('orders');
    }
}
