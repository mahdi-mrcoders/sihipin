<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Penilaian_reviewer_kriteria as NilaiKriteria;
class Penilaian_reviewer_kriteria extends Model
{
    use HasFactory;
    protected $fillable=['id_penilaian_review','id_pengajuan','id_dosen_review','id_indikator','skor','bobot_x_skor'];
    public function nilaiKriteria()
    {
        return $this->hasOne(NilaiKriteria::class,'id_indikator','id');
    }
}
