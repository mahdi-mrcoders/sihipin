<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penelitianpkms_laporanprogres extends Model
{
    use HasFactory;
    protected $fillable=['id_pengajuan','id_jenis_progress','file_progress','jenis_laporan','validasi','steps'];
}
