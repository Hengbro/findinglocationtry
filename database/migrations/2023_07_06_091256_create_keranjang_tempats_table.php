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
        Schema::create('keranjang_tempats', function (Blueprint $table) {
            $table->id();
            $table->integer('tempatId')->default(0);
            $table->integer('userId')->default(0);
            $table->integer('productId')->default(0);
            $table->string('sum_qty')->nullable();
            $table->string('sum_harga')->nullable();
            $table->string('status')->nullable();
            $table->string('lastInsert')->nullable();
            $table->boolean('isActive')->default(false);
            $table->boolean('isStatusBuy')->default(false);
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
        Schema::dropIfExists('keranjang_tempats');
    }
};
