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
        Schema::create('komponens', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_item');
            $table->foreign('id_item')->references('id')->on('item_kegiatans')->onDelete('cascade'); // Pastikan ada tabel 'kegiatan' dengan kolom 'id'
            $table->unsignedBigInteger('id_satuan');
            $table->foreign('id_satuan')->references('id')->on('satuans')->onDelete('cascade');
            $table->integer('volume');
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
        Schema::dropIfExists('komponens');
    }
};
