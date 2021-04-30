<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::fallback(function () {
    return response()->json([
        'message' => 'Terjadi kesalahan',
        'status' => 404,
        'error' => 'Endpoint tidak ditemukan'
    ], 404);
});

Route::post('/login', 'AuthController@login');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//Bencana
Route::get('/bencana','BencanaController@infoBencana');
Route::post('/bencana', 'BencanaController@tambahBencana');
Route::put('/bencana/{id}', 'BencanaController@ubahBencana');
Route::delete('/bencana/{id}', 'BencanaController@hapusBencana');


//Posko
Route::get('/posko', 'PoskoController@infoPosko');
Route::post('/posko', 'PoskoController@tambahPosko');
Route::put('/posko/{id}', 'PoskoController@ubahPosko');
Route::delete('/posko/{id}', 'PoskoController@hapusPosko');

//Penerimaan Logistikk
Route::get('/penerimaan-logistik', 'PenerimaanLogistikController@dataPenerimaanLogistik');

//Donatur
Route::get('/donatur', 'DonaturController@infoDonatur');
Route::post('/donatur', 'DonaturController@tambahDonatur');
Route::put('/donatur/{id}', 'DonaturController@ubahDonatur');
Route::delete('/donatur/{id}', 'DonaturController@hapusDonatur');


//Petugas Posko
Route::get('/petugas-posko', 'UserController@infoPetugasPosko');
Route::post('/petugas-posko', 'UserController@tambahPetugasPosko');
Route::put('/petugas-posko/{id}', 'UserController@ubahPetugasPosko');
Route::delete('/petugas-posko/{id}', 'UserController@hapusPetugasPosko');
