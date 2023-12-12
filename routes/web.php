<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('app');
});

Route::get('/{any}', function () {
    return view('app');
})->where('eny', '.*');

Route::get('/data-dosen/{any}', function () {
    return view('app');
})->where('eny', '.*');

Route::get('/data-dosen/{id}/{any}', function () {
    return view('app');
})->where('eny', '.*');

Route::get('/data-pengguna/{any}', function () {
    return view('app');
})->where('eny', '.*');

Route::get('/data-pengguna/{id}/{any}', function () {
    return view('app');
})->where('eny', '.*');

Route::get('/data-skema/{any}', function () {
    return view('app');
})->where('eny', '.*');

Route::get('/data-skema/{id}/{any}', function () {
    return view('app');
})->where('eny', '.*');

Route::get('/skema/{any}', function () {
    return view('app');
})->where('eny', '.*');
Route::get('/skema/{id}/{any}', function () {
    return view('app');
})->where('eny', '.*');

Route::get('storage/{filename}', function ($filename) {
    $path = 'public/uploads/' . $filename; // Adjust this path according to your storage structure

    if (!Storage::exists($path)) {
        abort(404);
    }

    $file = Storage::get($path);
    $type = Storage::mimeType($path);

    return response($file, 200)->header("Content-Type", $type);
});
