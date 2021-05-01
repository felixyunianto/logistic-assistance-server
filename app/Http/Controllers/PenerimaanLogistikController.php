<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PenerimaanLogistik;
use Auth;
use Validator;

class PenerimaanLogistikController extends Controller
{

    public function __construct(){
        $this->middleware('auth:api')->except('infoPenerimaanLogistik');
    }

    public function infoPenerimaanLogistik() {
        $data_penerimaan_logistik = PenerimaanLogistik::orderBy('tanggal')->get();
        
        return response()->json([
            'message' => 'Berhasil menampilkan data penerimaan logistik',
            'status' => 200,
            'data' => $data_penerimaan_logistik
        ],200);
    }

    public function tambahPenerimaanLogistik(Request $request) {
        $rules = [
            'id_posko' => 'required',
            'jenis_kebutuhan' => 'required',
            'keterangan' => 'required',
            'jumlah' => 'required',
            'tanggal' => 'required'
        ];

        $messages = [
            'required' => ':attribute tidak boleh kosong',
        ];

        $validation = Validator::make($request->all(), $rules, $messages);

        if($validation->fails()) {
            return response()->json([
                'message' => 'Terjadi kesalahan',
                'status' => 401,
                'error' => $validation->errors()
            ], 401);
        }

        $data_penerimaan_logistik = PenerimaanLogistik::create([
            'id_posko' => $request->id_posko,
            'jenis_kebutuhan' => $request->jenis_kebutuhan,
            'keterangan' => $request->keterangan,
            'jumlah' => $request->jumlah,
            'status' => 'Proses',
            'tanggal' => $request->tanggal  
        ]);

        return response()->json([
            'message' => 'Berhasil menambahkan penerimaan logistik',
            'status' => 200,
            'data' => $data_penerimaan_logistik
        ], 200);
    }

    public function ubahPenerimaanLogistik(Request $request, $id){
        $data_penerimaan_logistik = PenerimaanLogistik::findOrFail($id);
        
        $data_penerimaan_logistik->update([
            'id_posko' => $request->id_posko,
            'jenis_kebutuhan' => $request->jenis_kebutuhan,
            'keterangan' => $request->keterangan,
            'jumlah' => $request->jumlah,
            'status' => $data_penerimaan_logistik->status,
            'tanggal' => $request->tanggal  
        ]);

        return response()->json([
            'message' => 'Berhasil mengubah penerimaan logistik',
            'status' => 200,
            'data' => $data_penerimaan_logistik
        ], 200);
    }

    public function hapusPenerimaanLogistik($id){
        $data_penerimaan_logistik = PenerimaanLogistik::findOrFail($id);
        $data_penerimaan_logistik->delete();

        return response()->json([
            'message' => 'Berhasil menghapus penerimaan logistik',
            'status' => 200,
            'data' => $data_penerimaan_logistik
        ], 200);
    }
}
