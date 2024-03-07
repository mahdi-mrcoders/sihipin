<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Models\PenelitianPengajuan;
use App\Models\MediaFile;
use Illuminate\Http\Request;

class DataFileController extends Controller
{
    public function getDocxFile($filename)
    {
        $filePath = storage_path('app/public/uploads/' . $filename); // Assuming the file is in the storage/app directory
        $file = Storage::disk('public')->get('uploads/' . $filename); // Ganti dengan path file dokumen Anda

        // Cek apakah file ada
        if (!file_exists($filePath)) {
            return response()->json(['message' => 'File not found.'], 404);
        }


        return response($file, 200, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'Content-Disposition' => 'inline; filename="' . $filename . '"',
        ]);
    }

    public function getPptFile($filename)
    {
        $filePath = storage_path('app/public/uploads/' . $filename); // Assuming the file is in the storage/app directory
        $file = Storage::disk('public')->get('uploads/' . $filename); // Ganti dengan path file dokumen Anda

        // Cek apakah file ada
        if (!file_exists($filePath)) {
            return response()->json(['message' => 'File not found.'], 404);
        }

        $headers = [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation'
        ];

        return Response::download($filePath, $filename, $headers);
    }

    public function getPdf($filename)
    {
        $filePath = storage_path('app/public/uploads/' . $filename); // Assuming the file is in the storage/app directory
        $file = Storage::disk('public')->get('uploads/' . $filename);

        return response($file, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $filename . '"',
        ]);
    }

    public function filepresentasi(Request $request, $id)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = $file->getClientOriginalName();
            $file->storeAs('uploads', $fileName, 'public');
            $dataPengajuan['file_presentasi'] = $fileName;
            PenelitianPengajuan::where('id', $id)->update($dataPengajuan);

            return response()->json($dataPengajuan);
        }
    }

    public function filemedia()
    {
        $dataFile = MediaFile::get();
       
        return response()->json($dataFile);
    }
    public function filemediacreate(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = $file->getClientOriginalName();
            $file->storeAs('uploads', $fileName, 'public');
            $dataFile = new MediaFile();
            $dataFile->nama_data = $request->nama_data;
            $dataFile->file = $fileName;
            $dataFile->save();

            return response()->json($dataFile);
        }
       
    }
    public function filemediaupdate(Request $request,$id)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = $file->getClientOriginalName();
            $file->storeAs('uploads', $fileName, 'public');
            $dataFile = MediaFile::find($id);
            $dataFile->nama_data = $request->nama_data;
            $dataFile->file = $fileName;
            $dataFile->save();

            return response()->json($dataFile);
        }else{
            $dataFile = MediaFile::find($id);
            $dataFile->nama_data = $request->nama_data;
            $dataFile->save();
            return response()->json($dataFile);
        }
    }

    public function filemediadelete($id)
    {
        MediaFile::where('id',$id)->delete();
        return response()->json([
            'message'=>'data dosen Deleted Successfully!!'
        ]);
    }
}
