<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenelitianAnggota extends Model
{
    use HasFactory;
    protected $table = 'penelitianpkms_anggota';
    protected $fillable =['id_pengajuan','nama_anggota'];
}
