<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penelitianpkms_kontrak extends Model
{
    use HasFactory;
    protected $fillable =['id_pengajuan','no_kontrak','pihak_satu','pihak_dua','mengetahui'];
}
