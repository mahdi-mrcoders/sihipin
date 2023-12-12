<?php

namespace App\Http\Controllers;

use App\Models\DataSkema;
use App\Models\DataSyarat;
use App\Models\JadwalSubmitedSkema as JadwaSubmited;
use App\Models\DataPeriode;
use Illuminate\Http\Request;

class DataSkemaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $periodeAktif = DataPeriode::where('status_periode','Y')->first();
        if($periodeAktif){
            $dataSkema = DataSkema::all();
            foreach ($dataSkema as $key => $skema) {
                $jadwal = JadwaSubmited::where('id_periode',$periodeAktif->id)->where('id_skema',$skema->id)->first();
                $dataSyarat = DataSyarat::where('id_skema', $skema->id)->get();
                $dataSkema[$key]['jadwal']= $jadwal ? ['start'=>$jadwal->start,'end'=>$jadwal->end]:null;
                $dataSkema[$key]['syarat'] = $dataSyarat;
            }
        }else{
            $dataSkema = (object)[];
        }
        
        return response()->json($dataSkema);
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
        $dataSkema = [
            'nama_skema' => $request->nama_skema,
            'jumlah_anggota' => $request->jumlah_anggota,
            'status_skema' => $request->status_skema,
            'kode_program'=>$request->program_skema,
            'ketua_jabfung'=>$request->ketua_jabfung
        ];
        $InsertSkema = DataSkema::create($dataSkema);
        $last_id = $InsertSkema->getKey();
        foreach ($request->syarat as $key => $value) {
            $dataSyarat[] = [
                'id_skema' => $last_id,
                'persyaratan' => $value
            ];
        }
        $insertSyarat = DataSyarat::insert($dataSyarat);
        return response()->json([
            'message' => 'data stored',
            'data' => $dataSyarat
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DataSkema  $dataSkema
     * @return \Illuminate\Http\Response
     */
    public function show($dataSkema)
    {
        $dataSkema = DataSkema::where('id', $dataSkema)->first();
        $dataSyarat = DataSyarat::where('id_skema', $dataSkema->id)->get();
        $dataSkema['syarat'] = $dataSyarat;

        return response()->json($dataSkema);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DataSkema  $dataSkema
     * @return \Illuminate\Http\Response
     */
    public function edit(DataSkema $dataSkema)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DataSkema  $dataSkema
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $dataSkemas)
    {
        $dataSkema = [
            'nama_skema' => $request->nama_skema,
            'jumlah_anggota' => $request->jumlah_anggota,
            'status_skema' => $request->status_skema,
            'kode_program'=>$request->program_skema,
            'ketua_jabfung'=>$request->ketua_jabfung
        ];
        DataSkema::where('id',$dataSkemas)->update($dataSkema);
        foreach ($request->syarat as $key => $value) {
            $idsyarat[]=[
                'id'=>$request->idsyarat[$key]
            ];
            if ($request->idsyarat[$key] == 0) {
                $InsertSyarat= [
                    'id_skema' => $dataSkemas,
                    'persyaratan' => $value,
                ];
                DataSyarat::insert($InsertSyarat);
            } else {
                $UpdateSyarat=[
                    'id_skema'=>$dataSkemas,
                    'persyaratan'=>$value,
                ];
                DataSyarat::where('id',$request->idsyarat[$key])->update($UpdateSyarat);
            }
        }
        return response()->json([
            'message' => 'data stored',
            'data' => ''
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DataSkema  $dataSkema
     * @return \Illuminate\Http\Response
     */
    public function destroy($dataSkema)
    {
        DataSkema::where('id',$dataSkema)->delete();
        DataSyarat::where('id_skema',$dataSkema)->delete();
        return response()->json([
            'message'=>'data dosen Deleted Successfully!!'
        ]);
    }
}
