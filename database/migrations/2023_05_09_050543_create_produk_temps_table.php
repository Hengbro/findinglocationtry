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
        Schema::create('produk_temps', function (Blueprint $table) {
            $table->id();
            $table->integer('tempatId')->unsigned();
            $table->integer('categoryId')->nullable();
            $table->string('name');
            $table->integer('price');
            $table->string('image')->nullable();
            $table->string('category')->nullable();
            $table->string('description');
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
        Schema::dropIfExists('produk_temps');
    }
};
