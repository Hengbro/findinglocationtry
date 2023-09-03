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
        Schema::create('keranjang_products', function (Blueprint $table) {
            $table->id();
            $table->integer('tempatId')->default(0);
            $table->integer('userId')->default(0);
            $table->integer('productId')->default(0);
            $table->string('qty')->nullable();
            $table->string('tot_harga')->nullable();
            $table->string('note')->nullable();
            $table->boolean('isOrder')->default(false);
            $table->boolean('isActive')->default(true);
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
        Schema::dropIfExists('keranjang_products');
    }
};
