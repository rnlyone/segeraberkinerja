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
        Schema::create('kegiatans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_program')->constrained('programs')->onDelete('cascade');
            $table->year('tahun');
            $table->string('kode')->nullable();
            $table->string('nama_kegiatan');
            $table->bigInteger('pagu_anggaran')->nullable();
            $table->bigInteger('pagu_indikatif')->nullable();
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
        Schema::dropIfExists('kegiatans');
    }
};
