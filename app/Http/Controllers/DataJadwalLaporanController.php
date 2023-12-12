<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataJenisLaporan;

class DataJadwalLaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dataJadwal = DataJenisLaporan::all()
        ->map(function ($submited) {
            return $this->transformData($submited);
        });
        return response()->json($dataJadwal);
    }

    protected function transformData($submited)
    {
        $originStart = \Carbon\Carbon::parse($submited->start);
        $originEnd = \Carbon\Carbon::parse($submited->end);

        return [
            'id' => $submited->id,
            'jenis_laporan' => $submited->jenis_laporan,
            'start' => $originStart->isoFormat('YYYY-MM-DD HH:mm'),
            'end' => $originEnd->isoFormat('YYYY-MM-DD HH:mm')
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
        //
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
        DataJenisLaporan::where('id', $id)->update([
            'jenis_laporan' => $request->jenis_laporan,
            'start' => $request->start,
            'end' => $request->end
        ]);
        return response()->json([
            'status' => true,
            'message' => 'successfully!!!',
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
