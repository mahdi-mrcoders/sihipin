<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenilaianIndikator extends Model
{
    use HasFactory;
    protected $fillable =['id_kriteria','indikator_penilaian','bobot'];

}
