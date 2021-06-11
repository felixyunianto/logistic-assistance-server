<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LogistikKeluar;
use App\Validator;

class LogistikKeluarController extends Controller
{
    public function infoLogistikKeluar(Request $request){
        $data_logistik_keluar = LogistikKeluar::orderBy('created_at', 'DESC')->get();

        return response()->json([
            'message' => 'Berhasi menampilkan data logistik keluar',
            'status' => 200,
            'data' => $data_logistik_keluar
        ],200);
    }

    public function tambahLogistikKeluar(Request $request){
        $rules = [
            'jenis_kebutuhan' => 'required',
            'keterangan' => 'required',
            'jumlah' => 'required',
            'pengirim' => 'required',
            'id_posko' => 'required',
            'status' => 'required|in:Proses,Terima',
            'tanggal' => 'required'
        ];

        $messages = [
            'required' => 'Bidang :attribute tidak boleh kosong',
            'in' => 'Pemilihan :attribute salah atau tidak ditemukan'
        ];

        $validation = Validator::make($request->all(), $rules, $messages);

        if($validation->fails()){
            return response()->json([
                'message' => 'Terjadi kesalahan',
                'status' => 403,
                'error' => $validation->errors()
            ]);
        }

        $data_logistik_keluar = LogistikKeluar::create([
            'jenis_kebutuhan' => $request->jenis_kebutuhan
            'keterangan' => $request->keterangan
            'jumlah' => $request->jumlah
            'pengirim' => $request->pengirim
            'id_posko' => $request->id_posko
            'status' => $request->status
            'tanggal' => $request->tanggal
        ]);

        return response()->json([
            'message' => 'Berhasil menambahkan data logistik keluar',
            'status' => 200,
            'data' => data_logistik_keluar
        ], 200)
    }
}
