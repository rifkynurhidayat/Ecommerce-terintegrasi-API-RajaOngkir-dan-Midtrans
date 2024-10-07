<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('categories_id'); 
            $table->string('product_name', 50);
            $table->integer('product_price');
            $table->integer('stock_s');
            $table->integer('stock_m');
            $table->integer('stock_l');
            $table->integer('stock_xl');
            $table->integer('weight');
            $table->text('description');
            $table->string('img_product');
            $table->timestamps();

            $table->foreign('categories_id')->references('id')->on('categories');
     
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
