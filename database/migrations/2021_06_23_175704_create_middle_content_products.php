<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMiddleContentProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('middle_content_products', function (Blueprint $table) {
            $table->unsignedBigInteger('middle_content_id');
            $table->unsignedBigInteger('product_id')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('sub_categorie_id')->nullable();
            $table->foreign('middle_content_id')->references('id')->on('middle_contents')->onDelete('cascade');;
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');;
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');;
            $table->foreign('sub_categorie_id')->references('id')->on('sub_categories')->onDelete('cascade');;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('middle_content_products');
    }
}
