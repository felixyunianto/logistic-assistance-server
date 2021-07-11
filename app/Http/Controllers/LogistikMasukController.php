<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LogistikMasuk;
use Validator;

class LogistikMasukController extends Controller
{
    public function __construct(){
        $this->middleware('auth:api');
    }

    public function infoLogistikMasuk() {
        $data_logistik_masuk = LogistikMasuk::orderBy('created_at', 'DESC')->get();

        return response()->json([
            'message' => ' Berhasil menampilkan data logistik masuk',
            'status' => 200,
            'data' => $data_logistik_masuk
        ]);
    }

    public function tambahLogistikMasuk(Request $request) {
        $rules = [
            'jenis_kebutuhan' => 'required',
            'keterangan' => 'required',
            'jumlah' => 'required',
            'pengirim' => 'required',
            'id_posko' => 'required',
            'tanggal' => 'required'
        ];

        $messages = [
            'required' => 'Bidang :attribute tidak boleh kosong',
        ];

        $validation = Validator::make($request->all(), $rules, $messages);

        if($validation->fails()){
            return response()->json([
                'message' => 'Terjadi kesalahan',
                'status' => 403,
                'error' => $validation->errors()
            ]);
        }

        $data_logistik_masuk = LogistikMasuk::create([
            'jenis_kebutuhan' => $request->jenis_kebutuhan,
            'keterangan' => $request->keterangan,
            'jumlah' => $request->jumlah,
            'pengirim' => $request->pengirim,
            'id_posko' => $request->id_posko,
            'tanggal' => $request->tanggal
        ]);

        return response()->json([
            'message' => 'Berhasil menambahkan data logistik masuk',
            'status' => 200,
            'data' => $data_logistik_masuk
        ], 200);
    }

    public function ubahLogistikMasuk(Request $request, $id){
        $rules = [
            'jenis_kebutuhan' => 'required',
            'keterangan' => 'required',
            'jumlah' => 'required',
            'pengirim' => 'required',
            'id_posko' => 'required',
            'tanggal' => 'required'
        ];

        $messages = [
            'required' => 'Bidang :attribute tidak boleh kosong',
        ];

        $validation = Validator::make($request->all(), $rules, $messages);

        if($validation->fails()){
            return response()->json([
                'message' => 'Terjadi kesalahan',
                'status' => 403,
                'error' => $validation->errors()
            ],403);
        }

        $data_logistik_masuk = LogistikMasuk::findOrFail($id);

        $data_logistik_masuk->update([
            'jenis_kebutuhan' => $request->jenis_kebutuhan,
            'keterangan' => $request->keterangan,
            'jumlah' => $request->jumlah,
            'pengirim' => $request->pengirim,
            'id_posko' => $request->id_posko,
            'tanggal' => $request->tanggal
        ]);

        return response()->json([
            'message' => 'Berhasil mengubah data logistik keluar',
            'status' => 200,
            'data' => $data_logistik_masuk
        ], 200);
    }

    public function hapusLogistikMasuk($id) {
        $data_logistik_masuk = LogistikMasuk::findOrFail($id);

        $data_logistik_masuk->delete();

        return response()->json([
            'message' => 'Berhasil hapus data logistik keluar',
            'status' => 200,
            'data' => $data_logistik_masuk
        ], 200);
    }
}
