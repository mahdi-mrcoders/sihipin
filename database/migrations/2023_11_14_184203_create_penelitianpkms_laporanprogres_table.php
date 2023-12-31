<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenelitianpkmsLaporanprogresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penelitianpkms_laporanprogres', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_pengajuan');
            $table->integer('id_jenis_progress');
            $table->string('file_progress');
            $table->enum('validasi', ['prosess', 'Terima', 'Tolak']);
            $table->integer('steps');
            $table->string('alasan_tolak');
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
        Schema::dropIfExists('penelitianpkms_laporanprogres');
    }
}
