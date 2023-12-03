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
        Schema::create('s_k_p_d_s', function (Blueprint $table) {
            $table->id();
            $table->string('nama_skpd');
            $table->string('kode')->nullable();
            $table->text('foto_skpd')->nullable();
            $table->integer('level_otoritas');
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
        Schema::dropIfExists('s_k_p_d_s');
    }
};
