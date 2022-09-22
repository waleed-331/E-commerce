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
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('name');
            $table->string('image');
            $table->date('expiration_date');
            $table->json('periods');
            $table->json('discounts');
            $table->integer('quantity');
            $table->integer('views');
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->string('phone');
            $table->string('facebook');
            $table->longText('details')->nullable();
            $table->integer('price');
            $table->integer('price_after_discount');
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
