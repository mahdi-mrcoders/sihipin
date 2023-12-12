<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenilaianReviewersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penilaian_reviewers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_reviewer');
            $table->integer('id_pengajuan');
            $table->integer('id_dosen_reviewer');
            $table->string('catatan');
            $table->integer('total_nilai');
            $table->integer('hasil_review')->comment('1:terima 2:terima/revisi 3:tolak');
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
        Schema::dropIfExists('penilaian_reviewers');
    }
}
