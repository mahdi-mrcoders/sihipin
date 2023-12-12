<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Penilaian_reviewer extends Model
{
    use HasFactory;
    protected $fillable =['id_reviewer','id_pengajuan','id_dosen_reviewer','catatan','total_nilai','hasil_review'];
    
}
