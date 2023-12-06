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
        Schema::table('item_kegiatans', function (Blueprint $table) {
            $table->unsignedBigInteger('id_asb')->nullable()->after('id_kegiatan');
            $table->string('for_id')->after('id_asb');
        });
    }

    public function down()
    {
        Schema::table('item_kegiatans', function (Blueprint $table) {
            $table->dropColumn('id_asb');
            $table->dropColumn('for_id');
        });
    }
};
