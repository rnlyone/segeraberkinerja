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
        Schema::create('susunans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_asb')->constrained('satuans')->onDelete('cascade');
            $table->foreignId('id_satuan')->constrained('satuans')->onDelete('cascade');
            $table->float('volume');
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
        Schema::dropIfExists('susunans');
    }
};
