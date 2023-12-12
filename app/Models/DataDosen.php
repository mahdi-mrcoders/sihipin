<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataDosen extends Model
{
    use HasFactory;
    protected $table = 'dosens';
    protected $fillable = [
        'nrp', 'nidn','nama','no_hp','prodi','jabatan_fungsional','pangkat_golongan','email',
    ];
}
