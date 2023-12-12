<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenelitianpkmsKontraksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penelitianpkms_kontraks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_pengajuan');
            $table->string('no_kontrak');
            $table->date('pihak_satu');
            $table->date('pihak_dua');
            $table->date('mengetahui');
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
        Schema::dropIfExists('penelitianpkms_kontraks');
    }
}
