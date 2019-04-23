<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cid')->default(0);
            $table->string('name')->nullable();
            $table->string('name_cn')->nullable();
            $table->string('sn')->nullable();
            $table->decimal('price', 10, 2)->default(0);
            $table->tinyInteger('is_up')->default(0);
            $table->dateTime('created_at')->nullable();
            $table->text('description')->nullable();
            $table->integer('is_include')->default(0);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('goods');
    }
}
