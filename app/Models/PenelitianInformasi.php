<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenelitianInformasi extends Model
{
    use HasFactory;
    protected $table = 'penelitianpkms_informasi';
    protected $fillable = [
        'id_pengajuan',
        'judul_penelitian',
        'bidang_ilmu',
        'nama_lengkap',
        'nrp',
        'nidn',
        'pangkat_golongan',
        'jabatan_fungsional',
        'program_studi',
        'alamat_kantor',
        'faks_kantor',
        'alamat_rumah',
        'telp',
        'email',
        'lokasi',
        'jangka_waktu',
        'biaya',
    ];
    public $timestamps = true;
}
