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
        Schema::create('lokasi_tempats', function (Blueprint $table) {
            $table->id();
            $table->integer('tempatId')->unsigned();
            $table->string('alamat');
            $table->string('label');
            $table->string('provinsi');
            $table->string('kota');
            $table->string('kecamatan')->nullable();
            $table->string('kodepos');
            $table->integer('provinsiId')->nullable();
            $table->integer('kotaId')->nullable();
            $table->integer('kecamatanId')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
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
        Schema::dropIfExists('lokasi_tempats');
    }
};
