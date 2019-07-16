<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCatalogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('catalogs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('category');
            $table->string('tags')->nullable();
            $table->string('name');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->text('image')->nullable();
            $table->integer('price');
            $table->integer('stock')->default(0);
            $table->integer('discount')->nullable();
            $table->string('discount_type')->nullable();
            $table->string('discount_description')->nullable();
            $table->string('sold')->default(0);
            $table->text('click')->nullable();
            $table->text('rate')->nullable();
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
        Schema::dropIfExists('catalogs');
    }
}
