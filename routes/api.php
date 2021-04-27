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

Route::post('/register', 'UserController@register');
Route::post('/login', 'UserController@login');

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

//Penerimaan Logistikk
Route::get('/penerimaan-logistik', 'PenerimaanLogistikController@dataPenerimaanLogistik');

//Donatur
Route::get('/donatur', 'DonaturController@infoDonatur');