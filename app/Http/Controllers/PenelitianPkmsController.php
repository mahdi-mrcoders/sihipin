<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PenelitianPengajuan as Pengajuan;
use App\Models\PenelitianAnggota as Anggota;
use App\Models\PenelitianInformasi as Informasi;
use App\Models\DataDosen;
use App\Models\DataSkema;
use App\Models\Penelitianpkms_reviewer as Reviewer;
use App\Models\Penelitianpkms_kontrak as Kontraks;
use App\Models\Penelitianpkms_laporanprogres as LProgress;
use App\Models\DataJenisLaporan as JenisLaporan;
use App\Models\DataPeriode;

class PenelitianPkmsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dataSubmited = [];
        $dataPeriode = request()->get('periode');
        $idPeriode = null; // Initialize idPeriode

        // Check if periode is set
        if ($dataPeriode) {
            $idPeriode = $dataPeriode;
        }

        $level = request()->get('level');
        $idDosen = request()->get('idsn');

        // Use switch instead of if-else for readability
        switch ($level) {
            case 1:
            case 4:
                $query = Pengajuan::with(['informasi', 'anggota', 'dataDosen', 'dataSkema', 'dataKontrak', 'dataProgress', 'dataReviewer', 'dataNilai', 'periode'])
                    ->orderBy('id', 'desc');

                if ($idPeriode) {
                    $query->where('id_periode', $idPeriode);
                }

                $dataSubmited = $query->get()->map(function ($submited) {
                    return $this->transformData($submited);
                });
                break;

            case 3:
                $query = Pengajuan::with(['informasi', 'anggota', 'dataDosen', 'dataSkema', 'dataKontrak', 'dataProgress', 'dataReviewer', 'dataNilai', 'periode'])
                    ->where('id_dosen', $idDosen)
                    ->orderBy('id', 'desc');

                if ($idPeriode) {
                    $query->where('id_periode', $idPeriode);
                }

                $dataSubmited = $query->get()->map(function ($submited) {
                    return $this->transformData($submited);
                });
                break;

            case 2:
                $pengajuanIds = Reviewer::where('id_dosen', $idDosen)->pluck('id_pengajuan');

                $query = Pengajuan::with(['informasi', 'anggota', 'dataDosen', 'dataSkema', 'dataKontrak', 'dataProgress', 'dataReviewer', 'dataNilai', 'periode'])
                    ->whereIn('id', $pengajuanIds)
                    ->orderBy('id', 'desc');

                if ($idPeriode) {
                    $query->where('id_periode', $idPeriode);
                }

                $dataSubmited = $query->get()->map(function ($submited) {
                    return $this->transformData($submited);
                });
                break;

            default:
                // Handle other cases if needed
                break;
        }

        return response()->json($dataSubmited);
    }

    protected function transformData($submited)
    {
        $originDate = \Carbon\Carbon::parse($submited->created_at);
        $newDataProgress = $submited->dataProgress;
        foreach ($submited->dataProgress as $key => $item) {
            $dataJenis = JenisLaporan::find($item->id_jenis_progress);
            $newDataProgress[$key]['jenis_laporan'] = $dataJenis->jenis_laporan;
            $newDataProgress[$key]['times'] = [
                'start' => $dataJenis->start,
                'end' => $dataJenis->end
            ];
        }

        $dataNilai = $submited->dataNilai;

        $averageNilai = 0;
        if (!$dataNilai->isEmpty()) {
            $nilai = $dataNilai->pluck('total_nilai')->toArray();


            $averageNilai = array_sum($nilai) / count($nilai);
        }

        return [
            'id' => $submited->id,
            'id_periode' => $submited->periode->id,
            'id_skema' => $submited->id_skema,
            'id_dosen' => $submited->id_dosen,
            'status_pengajuan' => $submited->status_pengajuan,
            'alasan_tolak' => $submited->alasan_tolak,
            'status_pemenang' => $submited->status_pemenang,
            'file_proposal' => $submited->file_proposal,
            'file_presentasi' => $submited->file_presentasi,
            'ketua_peneliti' => $submited->dataDosen->nama,
            'nama_skema' => $submited->dataSkema->nama_skema,
            'kode_skema' => $submited->dataSkema->kode_program,
            'periode' => $submited->periode->periode,
            'informasi' => $submited->informasi,
            'anggota' => $submited->anggota,
            'kontrak' => $submited->dataKontrak,
            'progress' => $submited->dataProgress->isEmpty() ? null : $newDataProgress,
            'reviewer' => $submited->dataReviewer,
            'datanilai' => $submited->dataNilai,
            'ratanilai' => $averageNilai,
            'tanggal_pengajuan' => $originDate->isoFormat('YYYY-MM-DD'),
            'created_at' => $originDate->isoFormat('DD-MM-YYYY HH:mm '),
        ];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $dataPeriode = DataPeriode::where('status_periode', 'Y')->first();
        $dataPengajuan = [
            'id_periode' => $dataPeriode->id,
            'id_dosen' => $request->id_dosen,
            'id_skema' => $request->id_skema,
        ];
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = $file->getClientOriginalName();
            $file->storeAs('uploads', $fileName, 'public');
            $dataPengajuan['file_proposal'] = $fileName;
        }
        $insertPengajuan = Pengajuan::create($dataPengajuan);
        $idPengajuan = $insertPengajuan->getKey();
        $dataInformasi = [
            'id_pengajuan' => $idPengajuan,
            'judul_penelitian' => $request->judul_penelitian,
            'bidang_ilmu' => $request->bidang_ilmu,
            'nama_lengkap' => $request->nama_lengkap,
            'nrp' => $request->nrp,
            'nidn' => $request->nidn,
            'pangkat_golongan' => $request->pangkat_golongan,
            'jabatan_fungsional' => $request->jabatan_fungsional,
            'program_studi' => $request->prodi,
            'alamat_kantor' => $request->alamat_kantor,
            'faks_kantor' => $request->telp_kantor,
            'alamat_rumah' => $request->alamat_rumah,
            'telp' => $request->hp,
            'email' => $request->email,
            'lokasi' => $request->lokasi_penelitian,
            'jangka_waktu' => $request->waktu_penelitian,
            'biaya' => $request->biaya_penelitian,
        ];
        // $insertInformasi = Informasi::create($dataInformasi);
        foreach ($request->jumlah_anggota as $key => $value) {
            $dataAnggota[] = [
                'id_pengajuan' => $idPengajuan,
                'nama_anggota' => $value
            ];
        }
        // $insertAnggota = Anggota::insert($dataAnggota);

        $getJenisLaporan = JenisLaporan::all();
        foreach ($getJenisLaporan as $steps => $item) {
            LProgress::create([
                'id_pengajuan' => $idPengajuan,
                'id_jenis_progress' => $item->id,
                'file_progress' => NULL,
                'validasi' => 'No Upload',
                'steps' => $steps + 1
            ]);
        }
        return response()->json([
            'message' => "data stored",
            'data' => ['informasi' => $dataInformasi, 'anggota' => $dataAnggota]
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $dataSubmited = Pengajuan::with(['informasi', 'anggota', 'dataDosen', 'dataSkema', 'dataKontrak', 'dataProgress'])
            ->where('id', $id)
            ->first();

        $transformedData = $dataSubmited ? $this->transformData($dataSubmited) : [];
        $httpCode = $dataSubmited ? 200 : 404;


        return response()->json($transformedData, $httpCode);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    function updatevalidasi(Request $request)
    {
        if ($request->status == 'Terima') {
            $datastatus = [
                'status_pengajuan' => $request->status,
                'status_pemenang' => 'In Review'
            ];
        } else {
            $datastatus = [
                'status_pengajuan' => $request->status,
                'status_pemenang' => 'Tolak',
                'alasan_tolak' => $request->alasan
            ];
        }
        Pengajuan::where('id', $request->id)->update($datastatus);
        return response()->json(true);
    }

    function updatevalidasipemenang(Request $request)
    {
        $datastatus = [
            'status_pemenang' => $request->status,
        ];
        Pengajuan::where('id', $request->id)->update($datastatus);
        return response()->json(true);
    }

    function createkontrak(Request $request)
    {
        if ($request->level == 1) {
            $getDataKOntrak = Kontraks::where('id_pengajuan', $request->id)->first();
            if ($getDataKOntrak) {
                Kontraks::where('id_pengajuan', $request->id)->update(['pihak_satu' => date('Y-m-d')]);
                $status = 'update kontrak';
            } else {
                $status = 'insert kontrak';
                Kontraks::create(['id_pengajuan' => $request->id, 'pihak_satu' => date('Y-m-d'), 'no_kontrak' => $request->no_kontrak]);
            }
        } elseif ($request->level == 3) {
            Kontraks::where('id_pengajuan', $request->id)->update(['pihak_dua' => date('Y-m-d')]);
        } elseif ($request->level == 4) {
            Kontraks::where('id_pengajuan', $request->id)->update(['mengetahui' => date('Y-m-d')]);
        }

        return response()->json($request->all());
    }

    function getprogress($id)
    {
        $lastRecord = LProgress::where('id_pengajuan', $id)->orderBy('id', 'desc')
            ->latest()
            ->first();
        if ($lastRecord) {
            $lastRecord['next_laporan'] = ($lastRecord->jenis_laporan == 'Progress' && $lastRecord->validasi == 'Terima' ? '75' : ($lastRecord->jenis_laporan == '75' && $lastRecord->validasi == 'Terima' ? "Akhir" : $lastRecord->jenis_laporan));
            $data = [
                'message' => 'Found',
                'data' => $lastRecord
            ];
        } else {
            $data = [
                'message' => 'Not Found',
                'data' => $lastRecord
            ];
        }
        return response()->json($data);
    }

    function uploadprogress(Request $request)
    {
        $dataProgress = [
            'id_pengajuan' => $request->id_pengajuan,
            'id_jenis_progress' => $request->id_jenis_progress,
            'validasi' => 'prosess'
        ];
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = $file->getClientOriginalName();
            $file->storeAs('uploads', $fileName, 'public');
            $dataProgress['file_progress'] = $fileName;
        }

        LProgress::where('id', $request->id_progress)->update($dataProgress);
        return response()->json($dataProgress);
    }

    public function validasiprogres(Request $request, $id)
    {
        LProgress::where('id', $id)->update(['validasi' => $request->validasi, 'alasan_tolak' => $request->alasan]);
        return response()->json(['id' => $id, 'req' => $request->all()]);
    }

    public function submitedexist($periode, $iddsn)
    {
        $dataSubmited = Pengajuan::where('id_dosen', $iddsn)->where('id_periode', $periode)->get();

        return response()->json($dataSubmited);
    }
}
