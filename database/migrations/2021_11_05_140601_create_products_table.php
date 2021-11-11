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
            $table->string('sku')->unique();
            $table->string('name');
            $table->decimal('price');
            $table->text('description');
            $table->text('features')->nullable();
            $table->text('directions_and_precautions')->nullable();
            $table->text('ingredients')->nullable();
            $table->integer('category_id');
            $table->integer('sub_category_id');
            $table->integer('variation_id')->nullable();
            $table->json('variations')->nullable();
            $table->integer('size_id')->nullable();
            $table->json('sizes')->nullable();
            $table->integer('volume_id')->nullable();
            $table->json('volumes')->nullable();
            $table->integer('packaging_id')->nullable();
            $table->json('packaging')->nullable();
            $table->integer('cap_id')->nullable();
            $table->json('caps')->nullable();
            $table->json('images')->nullable();
            $table->tinyInteger('rebranding')->default(0);
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
