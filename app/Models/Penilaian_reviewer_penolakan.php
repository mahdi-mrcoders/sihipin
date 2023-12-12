<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penilaian_reviewer_penolakan extends Model
{
    use HasFactory;
    protected $fillable=['id_penilaian_review','id_pengajuan','id_dosen_review','id_indikator'];
    
}
