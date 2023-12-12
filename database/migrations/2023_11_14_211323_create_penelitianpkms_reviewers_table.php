<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenelitianpkmsReviewersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penelitianpkms_reviewers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_pengajuan');
            $table->integer('id_dosen');
            $table->string('nama_reviewer');
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
        Schema::dropIfExists('penelitianpkms_reviewers');
    }
}
