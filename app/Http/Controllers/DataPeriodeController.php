<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataPeriode;

class DataPeriodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->get('aktif')) {
            $dataPeriode = DataPeriode::where('status_periode', 'Y')->first();
        } else {
            $dataPeriode = DataPeriode::all();
        }
        return response()->json($dataPeriode);
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
        $dataGPeriode = DataPeriode::create($request->all());
        return response()->json([
            'message' => 'Data berhasil di simpan',
            'data' => $request->all()
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
        if (request()->get('aktif')) {
            $dataPeriode = DataPeriode::where('status_periode', 'Y')->first();
        } else {
            $dataPeriode = DataPeriode::find($id);
        }
        return response()->json($dataPeriode);
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
    public function update(Request $request, DataPeriode $dataperiode)
    {
        $dataperiode->fill($request->post())->save();
        return response()->json([
            'message' => 'Data berhasil di ubah',
            'data' => $request->all()
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
