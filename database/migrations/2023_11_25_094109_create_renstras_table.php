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
        Schema::create('renstras', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_skpd')->constrained('s_k_p_d_s')->onDelete('cascade');
            $table->year('periode');
            $table->text('visi');
            $table->text('misi');
            $table->text('tujuan');
            $table->text('sasaran');
            $table->text('dokumen');
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
        Schema::dropIfExists('renstras');
    }
};
