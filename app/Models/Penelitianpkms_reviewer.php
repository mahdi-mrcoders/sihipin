<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PenelitianPengajuan as Pengajuan;

class Penelitianpkms_reviewer extends Model
{
    use HasFactory;
    protected $fillable = ['id_pengajuan', 'id_dosen', 'nama_reviewer'];
    
    public function pengajuan()
    {
        return $this->belongsTo(Pengajuan::class, 'id_pengajuan', 'id');
    }
}
