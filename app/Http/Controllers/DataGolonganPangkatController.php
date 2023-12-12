<?php

namespace App\Http\Controllers;

use App\Models\DataGolonganPangkat;
use Illuminate\Http\Request;

class DataGolonganPangkatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dataGolPang = DataGolonganPangkat::all();
        return response()->json($dataGolPang);
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
        $dataGolPang = DataGolonganPangkat::create($request->all());
        return response()->json([
            'message' => 'Data berhasil di simpan',
            'data' => $request->all()
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DataGolonganPangkat  $dataGolonganPangkat
     * @return \Illuminate\Http\Response
     */
    public function show(DataGolonganPangkat $dataGolonganPangkat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DataGolonganPangkat  $dataGolonganPangkat
     * @return \Illuminate\Http\Response
     */
    public function edit(DataGolonganPangkat $dataGolonganPangkat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DataGolonganPangkat  $dataGolonganPangkat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DataGolonganPangkat $datagolpang)
    {
        $datagolpang->fill($request->post())->save();
        return response()->json([
            'message' => 'Data berhasil di ubah',
            'data' => $request->all()
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DataGolonganPangkat  $dataGolonganPangkat
     * @return \Illuminate\Http\Response
     */
    public function destroy(DataGolonganPangkat $datagolpang)
    {
        $datagolpang->delete();
        return response()->json([
            'message'=>'data dosen Deleted Successfully!!'
        ]);
    }
}
