<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->unsigned();
            $table->integer('user_address_id')->unsigned();
            $table->string('payment_code');
            $table->string('payment_type');
            $table->string('description');
            $table->integer('value');
            $table->integer('price');
            $table->integer('total_price');
            $table->integer('discount')->nullable()->default(0);
            $table->string('discount_type')->nullable();
            $table->string('status')->default(0);
            $table->string('status_detail')->nullable();
            $table->string('resi_code')->nullable();
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
        Schema::dropIfExists('payments');
    }
}
