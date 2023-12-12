<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataDosenController;
use App\Http\Controllers\AuthUserController;
use App\Http\Controllers\DataSkemaController;
use App\Http\Controllers\PenelitianPkmsController;
use App\Http\Controllers\DataReviewer;
use App\Http\Controllers\DataPenilaianController;
use App\Http\Controllers\DataPeriodeController;
use App\Http\Controllers\DataJabfungController;
use App\Http\Controllers\DataGolonganPangkatController;
use App\Http\Controllers\DataFileController;
use App\Http\Controllers\DataJadwalSkemaController;
use App\Http\Controllers\DataJadwalLaporanController;
use App\Http\Controllers\DataInformasiController;
use Illuminate\Support\Facades\Storage;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::post('login', [AuthUserController::class, 'userauth']);

Route::resource('datadosen', DataDosenController::class, ['except' => ['create', 'edit']]);
Route::get('dosengroup/{email}', [DataDosenController::class, 'groupdosen']);
Route::patch('dosenfoto/{id}', [DataDosenController::class, 'uploadfoto']);
Route::resource('pengguna', AuthUserController::class, ['except' => ['create', 'edit']]);
Route::resource('dataskema', DataSkemaController::class, ['except' => ['create', 'edit']]);
Route::resource('penelitian', PenelitianPkmsController::class, ['except' => ['create', 'edit']]);
Route::post('updatevalidasi', [PenelitianPkmsController::class, 'updatevalidasi']);
Route::post('updatevalidasipemenang', [PenelitianPkmsController::class, 'updatevalidasipemenang']);
Route::post('createkontrak', [PenelitianPkmsController::class, 'createkontrak']);
Route::get('progress/{id}', [PenelitianPkmsController::class, 'getprogress']);
Route::post('uploadprogress', [PenelitianPkmsController::class, 'uploadprogress']);
Route::patch('validasiprogress/{id}', [PenelitianPkmsController::class, 'validasiprogres']);

Route::resource('datareviewer', DataReviewer::class, ['except' => ['create', 'edit']]);
Route::resource('datapenilaian', DataPenilaianController::class, ['except' => ['create', 'edit']]);
Route::resource('dataperiode', DataPeriodeController::class, ['except' => ['create', 'edit']]);
Route::get('submitedketua/{periode}/{idsn}', [PenelitianPkmsController::class, 'submitedexist']);

Route::resource('datajadwalusulan', DataJadwalSkemaController::class, ['except' => ['create', 'edit']]);
Route::resource('datajadwallaporan', DataJadwalLaporanController::class, ['except' => ['create', 'edit']]);
Route::resource('informasi', DataInformasiController::class, ['except' => ['create', 'edit']]);


Route::resource('datajabfung', DataJabfungController::class, ['except' => ['create', 'edit']]);
Route::resource('datagolpang', DataGolonganPangkatController::class, ['except' => ['create', 'edit']]);
Route::get('/filedocx/{filename}', [DataFileController::class, 'getDocxFile']);
Route::get('/fileppt/{filename}', [DataFileController::class, 'getPptFile']);
Route::get('filepdf/{filename}', [DataFileController::class, 'getPdf']);
Route::get('listusers', [AuthUserController::class, 'userexist']);
Route::get('listusers/level', [AuthUserController::class, 'userbylevel']);
Route::get('dosen/byemail/{email}', [DataDosenController::class, 'byemail']);

Route::get('/file/{filename}', function ($filename) {
    $path = storage_path('app/public/uploads/' . $filename);
    $url = Storage::url('app/public/uploads/' . $filename);
    return response()->json(url($url));
});

Route::get('bukupanduan',[DataFileController::class, 'filemedia']);
Route::post('bukupanduan',[DataFileController::class, 'filemediacreate']);
Route::patch('bukupanduan/{id}',[DataFileController::class, 'filemediaupdate']);


Route::patch('uploadppt/{id}', [DataFileController::class, 'filepresentasi']);
