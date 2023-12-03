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
        Schema::create('satuans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_kelompok');
            $table->foreign('id_kelompok')->references('id')->on('kelompoks')->onDelete('cascade');
            $table->enum('jenis_satuan', ['ssh', 'sbu', 'hspk', 'asb']);
            $table->string('kode');
            $table->string('nama_item');
            $table->text('spesifikasi')->nullable();
            $table->string('satuan');
            $table->bigInteger('harga');
            $table->string('kode_rekening')->nullable();
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
        Schema::dropIfExists('satuans');
    }
};
