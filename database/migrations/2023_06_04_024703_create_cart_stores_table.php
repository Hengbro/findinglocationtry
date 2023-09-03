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
        Schema::create('cart_stores', function (Blueprint $table) {
            $table->id();
            $table->integer('userId')->default(0);
            $table->integer('storeId')->default(0);
            $table->string('status')->nullable();
            $table->string('much_product')->nullable();
            $table->string('really_price')->nullable();
            $table->boolean('isSelected')->default(true);
            $table->boolean('isActive')->default(true);
            $table->string('lastInsert')->nullable();
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
        Schema::dropIfExists('cart_stores');
    }
};
