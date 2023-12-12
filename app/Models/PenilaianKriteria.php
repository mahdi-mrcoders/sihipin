<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PenilaianIndikator as Indikator;
class PenilaianKriteria extends Model
{
    use HasFactory;
    protected $fillable =['nama_kriteria','kode_program'];

    public function indikatorNilai()
    {
        return $this->hasMany(Indikator::class, 'id_kriteria', 'id');
    }
}
