<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penelitianpkms_reviewer as Reviewer;
use App\Models\PenelitianPengajuan as Pengajuan;
use Illuminate\Support\Str;

class DataReviewer extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
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
        $dataReviewerPost = $request->reviewerId;
        foreach($dataReviewerPost as $value){
            $explitData = Str::of($value)->explode(':')->toArray();
            Reviewer::create([
                'id_pengajuan'=>$request->id_pengajuan,
                'id_dosen'=>$explitData[0],
                'nama_reviewer'=>$explitData[1]
            ]);
        }
        Pengajuan::where('id',$request->id_pengajuan)->update(['status_pengajuan'=>'Terima','status_pemenang'=>'In Review']);
        return response()->json([
            'message'=>'data stored',
            'data'=>$request->all()
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
        $idsn = request()->get('idsn');
        if($idsn){
            $dataReviewer = Reviewer::where('id_pengajuan',$id)->where('id_dosen',$idsn)->get();
        }else{
            $dataReviewer = Reviewer::where('id_pengajuan',$id)->get();
        }
        
        return response()->json($dataReviewer);
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
        $dataReviewerPost = $request->reviewerId;
        Pengajuan::where('id', $id)->update(['status_pengajuan'=>'Terima','status_pemenang'=>'In Review']);
        foreach($dataReviewerPost as $ind=> $value){
            $explitData = Str::of($value)->explode(':')->toArray();
            Reviewer::where('id',$request->idrev[$ind])->update([
                'id_pengajuan'=>$id,
                'id_dosen'=>$explitData[0],
                'nama_reviewer'=>$explitData[1]
            ]);
            $dataList[]=[
                'id_pengajuan'=>$id,
                'id_dosen'=>$explitData[0],
                'nama_reviewer'=>$explitData[1]
            ];
        }
        // Pengajuan::where('id',$request->id)->update(['status_pengajuan'=>'In Review']);
        return response()->json([
            'message'=>'data stored',
            'data'=>$dataList
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
