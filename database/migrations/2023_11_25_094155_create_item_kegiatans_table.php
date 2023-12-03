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
        Schema::create('item_kegiatans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_kegiatan')->constrained('kegiatans')->onDelete('cascade');
            $table->string('kode')->nullable();
            $table->text('nama_sub');
            $table->text('kinerja')->nullable();
            $table->text('indikator')->nullable();
            $table->string('satuan')->nullable();
            $table->bigInteger('pagu_indikatif')->nullable();
            $table->bigInteger('pagu_anggaran')->nullable();

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
        Schema::dropIfExists('item_kegiatans');
    }
};
