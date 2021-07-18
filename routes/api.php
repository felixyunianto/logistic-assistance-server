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
Route::get('/penerimaan-logistik', 'PenerimaanLogistikController@infoPenerimaanLogistik');
Route::post('/penerimaan-logistik', 'PenerimaanLogistikController@tambahPenerimaanLogistik');
Route::put('/penerimaan-logistik/{id}', 'PenerimaanLogistikController@ubahPenerimaanLogistik');
Route::delete('/penerimaan-logistik/{id}', 'PenerimaanLogistikController@hapusPenerimaanLogistik');

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

//KebutuhanLogitik
Route::get('/kebutuhan-logistik', 'KebutuhanLogistikController@infoKebutuhanLogistik');
Route::get('/kebutuhan-logistik/posko/{id}','KebutuhanLogistikController@infoKebutuhanLogistikByPosko');
Route::post('/kebutuhan-logistik', 'KebutuhanLogistikController@tambahKebutuhanLogistik');
Route::put('/kebutuhan-logistik/{id}', 'KebutuhanLogistikController@ubahKebutuhanLogistik');
Route::delete('/kebutuhan-logistik/{id}', 'KebutuhanLogistikController@hapusKebutuhanLogistik');

//LogistikKeluar
Route::get('/logistik-keluar', 'LogistikKeluarController@infoLogistikKeluar');
Route::post('/logistik-keluar', 'LogistikKeluarController@tambahLogistikKeluar');
Route::put('/logistik-keluar/{id}', 'LogistikKeluarController@ubahLogistikKeluar');
Route::delete('/logistik-keluar/{id}', 'LogistikKeluarController@hapusLogistikKeluar');

//Logistik Masuk
Route::get('/logistik-masuk', 'LogistikMasukController@infoLogistikMasuk');
Route::post('/logistik-masuk', 'LogistikMasukController@tambahLogistikMasuk');
Route::put('/logistik-masuk/{id}', 'LogistikMasukController@ubahLogistikMasuk');
Route::delete('/logistik-masuk/{id}', 'LogistikMasukController@hapusLogistikMasuk');

//Penyaluran
Route::get('/penyaluran', 'PenyaluranController@infoPenyaluran');
Route::post('/penyaluran', 'PenyaluranController@tambahPenyaluran');
Route::put('/penyaluran/{id}', 'PenyaluranController@ubahPenyaluran');
Route::delete('/penyaluran/{id}', 'PenyaluranController@hapusPenyaluran');