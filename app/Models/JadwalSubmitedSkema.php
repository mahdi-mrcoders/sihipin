<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\DataPeriode as periode;
use App\Models\DataSkema;
class JadwalSubmitedSkema extends Model
{
    use HasFactory;
    protected $fillable =['id_periode','id_skema','start','end'];

    public function periode()
    {
        return $this->hasOne(Periode::class,'id','id_periode');
    }
    public function dataSkema()
    {
        return $this->hasOne(DataSkema::class, 'id', 'id_skema');
    }
}
