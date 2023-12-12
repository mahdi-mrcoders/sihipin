<?php

namespace App\Http\Controllers;

use App\Models\DataDosen;
use Illuminate\Http\Request;

class DataDosenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dataDosen = DataDosen::all();
        return response()->json($dataDosen);
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
        $dataDosen = DataDosen::create($request->all());
        return response()->json([
            'message'=>'Data berhasil di simpan',
            'data'=>$request->all()
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DataDosen  $dataDosen
     * @return \Illuminate\Http\Response
     */
    public function show($dataDosen)
    {
        $dataDosen = DataDosen::find($dataDosen);
        return response()->json($dataDosen);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DataDosen  $dataDosen
     * @return \Illuminate\Http\Response
     */
    public function edit(DataDosen $dataDosen)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DataDosen  $dataDosen
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,DataDosen $datadosen)
    {
        $datadosen->fill($request->post())->save();
        return response()->json([
            'message'=>'Data berhasil di ubah',
            'data'=>$request->all()
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DataDosen  $dataDosen
     * @return \Illuminate\Http\Response
     */
    public function destroy(DataDosen $datadosen)
    {
        $datadosen->delete();
        return response()->json([
            'message'=>'data dosen Deleted Successfully!!'
        ]);
    }

    public function byemail($datadosen){
        $dataDosen = DataDosen::where('email',$datadosen)->first();
        return response()->json($dataDosen);
    }

    public function groupdosen($args)
    {
        $dataDosen = DataDosen::groupBy('prodi')->get();
        
        foreach ($dataDosen as $key=>$item) {
            $data=[];
            $list=DataDosen::where('prodi',$item->prodi)->where('email','!=',$args)->get();
            foreach ($list as $items) {
                $lists=[];
                $lists['id']=$items->id;
                $lists['nama']=$items->nama;
                $data[]=$lists;
            }
            $options[]=[
                'prodi'=>$item->prodi,
                'dosen'=>$data
            ];
        }

        return response()->json($options);
    }
    public function uploadfoto(Request $request,$id)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = $file->getClientOriginalName();
            $file->storeAs('uploads', $fileName, 'public');
            $dataPengajuan['foto'] = $fileName;
            DataDosen::where('id',$id)->update($dataPengajuan);

            return response()->json($dataPengajuan);
        }
    }
}
