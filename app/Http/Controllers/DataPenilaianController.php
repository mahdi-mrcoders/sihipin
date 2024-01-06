<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PenilaianKriteria as Kriteria;
use App\Models\PenilaianIndikator as Indikator;
use App\Models\PenelitianPengajuan as Pengajuan;
use App\Models\Penelitianpkms_reviewer as Reviewer;
use App\Models\Penilaian_reviewer as Nilai;
use App\Models\Penilaian_reviewer_kriteria as NilaiKriteria;
use App\Models\Penilaian_reviewer_penolakan as Penolakans;

class DataPenilaianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $idpengajuan = request()->get('idp');
        $iddosen = request()->get('idsn');

        $skemaType = Pengajuan::with(['dataSkema'])
            ->where('id', request()->get('idp'))
            ->first();
        if ($skemaType) {
            $transformedData = $this->transformDataPengajuan($skemaType);
            $getDataNilaiReview = Nilai::where('id_pengajuan', $idpengajuan)->where('id_dosen_reviewer', $iddosen)->first();
            $dataAlasan = Penolakans::where('id_pengajuan', $idpengajuan)->where('id_dosen_review', $iddosen)->get();
            if ($getDataNilaiReview && $getDataNilaiReview->hasil_review == 3) {
                $getDataNilaiReview['alasan'] = $dataAlasan->map(function ($tolak) {
                    return $tolak->id_indikator;
                });
            }

            $dataPenilaian = Kriteria::with(['indikatorNilai'])
                ->where('kode_program', $transformedData['kode_skema'])
                ->get()
                ->map(function ($submited) use ($idpengajuan, $iddosen) {
                    return $this->transformData($submited, $idpengajuan, $iddosen);
                });
            $httCode = 200;
        } else {
            $dataPenilaian = [];
            $getDataNilaiReview = [];
            $httCode = 404;
        }

        return response()->json(['data' => $dataPenilaian, 'nilai' => $getDataNilaiReview], $httCode);
    }

    protected function transformData($submited, $idp, $idsn)
    {
        $dataIndikator = $submited->indikatorNilai->map(function ($indikator) use ($idp, $idsn) {
            $nilaiSkor = NilaiKriteria::where('id_pengajuan', $idp)->where('id_dosen_review', $idsn)->where('id_indikator', $indikator->id)->first();
            $indikator['skor'] = $nilaiSkor ? $nilaiSkor->skor : null;
            $indikator['nilai'] = $nilaiSkor ? $nilaiSkor->bobot_x_skor : null;
            return $indikator;
        });

        return [
            'id' => $submited->id,
            'nama_kriteria' => $submited->nama_kriteria,
            'indikator' => $dataIndikator,
        ];
    }

    protected function transformDataPengajuan($submited)
    {

        return [
            'kode_skema' => $submited->dataSkema->kode_program,
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
        $postPenilaian = [
            'id_reviewer' => Reviewer::where('id_pengajuan', $request->id_pengajuan)->where('id_dosen', $request->id_dosen)->first()->id,
            'id_pengajuan' => $request->id_pengajuan,
            'id_dosen_reviewer' => $request->id_dosen,
            'total_nilai' => $request->totalnilai,
            'hasil_review' => intval($request->hasil)
        ];
        $insertPenilaian = Nilai::create($postPenilaian);
        $idPeenilaianReview = $insertPenilaian->getKey();

        foreach ($request->compid as $key => $idkator) {
            NilaiKriteria::create([
                'id_penilaian_review' => $idPeenilaianReview,
                'id_pengajuan' => $request->id_pengajuan,
                'id_dosen_review' => $request->id_dosen,
                'id_indikator' => $idkator,
                'skor' => $request->compskors[$key],
                'bobot_x_skor' => $request->compnilai[$key]
            ]);
            $postNilaiKriteria[] = [
                'id_penilaian_review' => $idPeenilaianReview,
                'id_pengajuan' => $request->id_pengajuan,
                'id_dosen_review' => $request->id_dosen,
                'id_indikator' => $idkator,
                'skor' => $request->compskors[$key],
                'bobot_x_skor' => $request->compnilai[$key]
            ];
        }


        if (count($request->alasan) !== 0) {
            foreach ($request->alasan as $key => $alasan) {
                Penolakans::create([
                    'id_penilaian_review' => $idPeenilaianReview,
                    'id_pengajuan' => $request->id_pengajuan,
                    'id_dosen_review' => $request->id_dosen,
                    'id_indikator' => $alasan,
                ]);
                $PostPenolakan[] = [
                    'id_penilaian_review' => $idPeenilaianReview,
                    'id_pengajuan' => $request->id_pengajuan,
                    'id_dosen_review' => $request->id_dosen,
                    'id_indikator' => $alasan,
                ];
            }
        }
        return response()->json([
            'postPenilaian' => $postPenilaian,
            'postKirteria' => $postNilaiKriteria,
            'postPenolakan' => count($request->alasan) !== 0  ? 'ada' : 'tidak ada'
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
        //
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
        $postPenilaian = [
            'id_reviewer' => $request->id_penilain_review,
            'id_pengajuan' => $request->id_pengajuan,
            'id_dosen_reviewer' => $request->id_dosen,
            'total_nilai' => $request->totalnilai,
            'hasil_review' => intval($request->hasil)
        ];

        Nilai::where('id_reviewer', $request->id_penilain_review)
            ->where('id_pengajuan', $request->id_pengajuan)
            ->where('id_dosen_reviewer', $request->id_dosen)
            ->update($postPenilaian);

        foreach ($request->compid as $key => $idkator) {
            NilaiKriteria::where('id_penilaian_review', $request->id_penilain_review)
                ->where('id_pengajuan', $request->id_pengajuan)
                ->where('id_dosen_review', $request->id_dosen)
                ->where('id_indikator', $idkator)
                ->update([
                    'id_penilaian_review' => $request->id_penilain_review,
                    'id_pengajuan' => $request->id_pengajuan,
                    'id_dosen_review' => $request->id_dosen,
                    'id_indikator' => $idkator,
                    'skor' => $request->compskors[$key],
                    'bobot_x_skor' => $request->compnilai[$key]
                ]);
        }

        if ($request->alasan) {
            $getListAlasan = Penolakans::where('id_penilaian_review', $request->id_penilain_review)
                ->where('id_pengajuan', $request->id_pengajuan)
                ->where('id_dosen_review', $request->id_dosen)
                ->get();
            $listAlasan = [];
            foreach ($getListAlasan as $rows) {
                $listAlasan[] = $rows->id_indikator;
            }

            foreach ($request->alasan as $inputs) {
                if (!in_array($inputs, $listAlasan)) {
                    Penolakans::create([
                        'id_penilaian_review' => $request->id_penilain_review,
                        'id_pengajuan' => $request->id_pengajuan,
                        'id_dosen_review' => $request->id_dosen,
                        'id_indikator' => $inputs,
                    ]);
                }
            }

            foreach ($listAlasan as $list) {
                if (!in_array($list, $request->alasan)) {
                    Penolakans::where('id_penilaian_review', $request->id_penilain_review)
                        ->where('id_pengajuan', $request->id_pengajuan)
                        ->where('id_dosen_review', $request->id_dosen)
                        ->where('id_indikator', $list)
                        ->delete();
                }
            }
        }
        return response()->json([
            'id' => $id,
            'data' => $postPenilaian
        ]);
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
}
