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
            $table->integer('shop')->default(0);
            $table->string('shop_printer_id',100)->nullable();
            $table->string('username',100)->nullable();
            $table->string('firstname',100)->nullable();
            $table->string('lastname',100)->nullable();
            $table->string('mobile',100)->nullable();
            $table->string('address',300)->nullable();
            $table->string('city',100)->nullable();
            $table->string('postcode',100)->nullable();
            $table->string('country',100)->nullable();
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('price', 10, 2)->default(0);
            $table->text('specialrequests')->nullable();
            $table->string('ordernum',100)->nullable();
            $table->text('goods')->nullable();
            $table->string('order_pay',100)->default('Unpaid');
            $table->dateTime('created_at')->nullable();
            $table->string('takeawayType',100)->nullable();
            $table->string('paymentMethod',100)->nullable();
            $table->string('preorder_datetime',50)->nullable();
            $table->tinyInteger('flag')->default(0)->comment("0");
            $table->string('status',100)->defalut('incomplete');
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
