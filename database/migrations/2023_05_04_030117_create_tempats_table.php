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
        Schema::create('tempats', function (Blueprint $table) {
            $table->id();
            $table->integer('userId');
            $table->integer('alamatId')->nullable();
            $table->integer('categoriId')->nullable();
            $table->string('nameTempat');
            $table->string('imageTempat')->nullable();
            $table->string('kota');
            $table->string('kategori');
            $table->string('openH');
            $table->string('closeH');
            $table->string('imagaPemilik')->nullable();
            $table->string('deskription');
            $table->string('email');
            $table->string('phone');
            $table->string('status')->nullable();
            $table->boolean('isActive')->default(false);
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
        Schema::dropIfExists('tempats');
    }
};
