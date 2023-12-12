<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JadwalSubmitedSkema;

class DataJadwalSkemaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dataJadwal = JadwalSubmitedSkema::with(['dataSkema', 'periode'])
            ->where('hapus',0)
            ->get()
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
            'periode' => $submited->periode,
            'skema' => $submited->dataSkema,
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
        $checkExistJadwal = JadwalSubmitedSkema::where('id_periode', $request->id_periode)->first();
        if (!$checkExistJadwal) {
            foreach ($request->id_skema as $index => $item) {
                JadwalSubmitedSkema::create([
                    'id_periode' => $request->id_periode,
                    'id_skema' => $item,
                    'start' => $request->start[$index],
                    'end' => $request->end[$index]
                ]);
            }
            return response()->json([
                'status' => true,
                'message' => 'successfully!!!',
                'data' => $request->all()
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Periode yang anda seting sudah ada tidak dapat membuat lagi',
                'data' => $request->all()
            ]);
        }
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
        JadwalSubmitedSkema::where('id', $id)->update([
            'id_periode' => $request->id_periode,
            'id_skema' => $request->id_skema,
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
        JadwalSubmitedSkema::where('id', $id)->update([
            'hapus' => 1
        ]);
        return response()->json([
            'status' => true,
            'message' => 'successfully!!!',
        ]);
    }
}
