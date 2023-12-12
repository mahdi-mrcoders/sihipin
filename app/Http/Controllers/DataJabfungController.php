<?php

namespace App\Http\Controllers;

use App\Models\DataJabfung;
use Illuminate\Http\Request;

class DataJabfungController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dataJabfung = DataJabfung::all();
        return response()->json($dataJabfung);
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
        $dataJabfung = DataJabfung::create($request->all());
        return response()->json([
            'message' => 'Data berhasil di simpan',
            'data' => $request->all()
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DataJabfung  $dataJabfung
     * @return \Illuminate\Http\Response
     */
    public function show(DataJabfung $datajabfung)
    {
        return response()->json($datajabfung);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DataJabfung  $dataJabfung
     * @return \Illuminate\Http\Response
     */
    public function edit(DataJabfung $dataJabfung)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DataJabfung  $dataJabfung
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DataJabfung $datajabfung)
    {
        $datajabfung->fill($request->post())->save();
        return response()->json([
            'message' => 'Data berhasil di ubah',
            'data' => $request->all()
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DataJabfung  $dataJabfung
     * @return \Illuminate\Http\Response
     */
    public function destroy(DataJabfung $datajabfung)
    {
        $datajabfung->delete();
        return response()->json([
            'message'=>'data dosen Deleted Successfully!!'
        ]);
    }
}
