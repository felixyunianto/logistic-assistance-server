<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Donatur;
use Validator;

class DonaturController extends Controller
{
    public function __construct(){
        $this->middleware('auth:api')->except('infoDonatur');
    }

    public function infoDonatur() {
        $data_donatur = Donatur::orderBy('nama')->get();

        return response()->json([
            'message' => 'Berhasil menampilkan data donatur',
            'status' => 200,
            'data' => $data_donatur
        ],200);
    }

    public function tambahDonatur(Request $request) {
        $rules =[
            'nama' => 'required',
            'jenis_kebutuhan' => 'required',
            'keterangan' => 'required',
            'alamat' => 'required',
            'posko_penerima' => 'required',
            'tanggal' => 'required'
        ];

        $messages = [
            'required' => ':attribute tidak boleh kosong'
        ];

        $validation = Validator::make($request->all(), $rules, $messages);

        if($validation->fails()){
            return response()->json([
                'message' => 'Terjadi kesalahan',
                'status' => 401,
                'error' => $validation->errors()
            ], 401);
        }

        $data_donatur = Donatur::create([
            'nama' => $request->nama,
            'jenis_kebutuhan' => $request->jenis_kebutuhan,
            'keterangan' => $request->keterangan,
            'alamat' => $request->alamat,
            'posko_penerima' => $request->posko_penerima,
            'tanggal' => $request->tanggal
        ]);

        return response()->json([
            'message' => 'Berhasil menambahkan data donatur',
            'status' => 200,
            'data' => $data_donatur
        ],200);
    }

    public function ubahDonatur(Request $request, $id) {
        $data_donatur = Donatur::findOrFail($id);

        $data_donatur->update([
            'nama' => $request->nama,
            'jenis_kebutuhan' => $request->jenis_kebutuhan,
            'keterangan' => $request->keterangan,
            'alamat' => $request->alamat,
            'posko_penerima' => $request->posko_penerima,
            'tanggal' => $request->tanggal
        ]);

        return response()->json([
            'message' => 'Berhasil mengubah data donatur',
            'status' => 200,
            'data' => $data_donatur
        ],200);
    }

    public function hapusDonatur($id) {
        $data_donatur = Donatur::findOrFail($id);
        $data_donatur->delete();

        return response()->json([
            'message' => 'Berhasil menghapus data donatur',
            'status' => 200,
            'data' => $data_donatur
        ],200);

    }
}
