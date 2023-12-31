<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PenelitianAnggota as Anggota;
use App\Models\PenelitianInformasi as Informasi;
use App\Models\DataDosen;
use App\Models\DataSkema;
use App\Models\Penelitianpkms_kontrak as Kontrak;
use App\Models\Penelitianpkms_laporanprogres as Progress;
use App\Models\Penelitianpkms_reviewer as Reviewer;
use App\Models\Penilaian_reviewer as Nilai;
use App\Models\DataPeriode as Periode;

class PenelitianPengajuan extends Model
{
    use HasFactory;
    protected $table = 'penelitianpkms_pengajuans';
    protected $fillable = ['id_periode', 'id_dosen', 'id_skema', 'file_proposal', 'status_pengajuan', 'status_pemenang', 'alasan_tolak'];
    public $timestamps = true;

    public function informasi()
    {
        return $this->hasOne(Informasi::class, 'id_pengajuan', 'id');
    }

    public function anggota()
    {
        return $this->hasMany(Anggota::class, 'id_pengajuan', 'id');
    }

    public function dataDosen()
    {
        return $this->hasOne(DataDosen::class, 'id', 'id_dosen');
    }

    public function dataSkema()
    {
        return $this->hasOne(DataSkema::class, 'id', 'id_skema');
    }

    public function dataKontrak()
    {
        return $this->hasOne(Kontrak::class, 'id_pengajuan', 'id');
    }

    public function dataProgress()
    {
        return $this->hasMany(Progress::class, 'id_pengajuan', 'id');
    }
    public function dataReviewer()
    {
        return $this->hasMany(Reviewer::class, 'id_pengajuan', 'id');
    }
    public function dataNilai()
    {
        return $this->hasMany(Nilai::class, 'id_pengajuan', 'id');
    }

    public function periode()
    {
        return $this->hasOne(Periode::class, 'id', 'id_periode');
    }
}
