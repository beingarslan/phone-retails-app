<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
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
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->double('price')->nullable();
            $table->double('discount')->nullable();
            $table->string('model')->nullable();
            $table->string('ean')->nullable();
            $table->string('sku')->nullable();
            $table->string('slug')->nullable();
            $table->string('image')->default('default.png');
            $table->string('meta_title')->nullable();
            $table->boolean('status')->nullable()->default(1);
            $table->foreignId('brand_id')->nullable()->constrained('brands')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('category_id')->nullable()->constrained('categories')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('capacity_id')->nullable()->constrained('capacities')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('color_id')->nullable()->constrained('colors')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('products');
    }
}
