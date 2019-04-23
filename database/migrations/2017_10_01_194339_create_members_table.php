<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username',100)->nullable();
            $table->string('password')->nullable();
            $table->string('firstname',30)->nullable();
            $table->string('lastname',30)->nullable();
            $table->string('address')->nullable();
            $table->string('city',50)->nullable();
            $table->string('postcode',30)->nullable();
            $table->string('country',30)->nullable();
            $table->string('mobile',100)->nullable();
            $table->dateTime('created_at')->nullable();
            $table->text('cartInfo')->nullable();
            $table->string('remember_token',200)->nullable();
            $table->string('deli_method',100)->default('Delivery')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('members');
    }
}
