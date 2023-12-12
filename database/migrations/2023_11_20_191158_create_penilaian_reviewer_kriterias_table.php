<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenilaianReviewerKriteriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penilaian_reviewer_kriterias', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_penilaian_review');
            $table->integer('id_pengajuan');
            $table->integer('id_dosen_review');
            $table->integer('id_indikator');
            $table->integer('skor');
            $table->integer('bobot_x_skor');
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
        Schema::dropIfExists('penilaian_reviewer_kriterias');
    }
}
