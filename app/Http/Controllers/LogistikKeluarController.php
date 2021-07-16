<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LogistikKeluar;
use Validator;
use Auth;

class LogistikKeluarController extends Controller
{
    public function __construct(){
        $this->middleware('auth:api');
    }

    public function infoLogistikKeluar(){
        $data_logistik_keluar = LogistikKeluar::with('posko')->orderBy('created_at', 'DESC')->get();

        $results = [];

        foreach($data_logistik_keluar as $logistik_keluar){
            $results[] = [
                "id" => $logistik_keluar->id,
                "jenis_kebutuhan" => $logistik_keluar->jenis_kebutuhan,
                "keterangan" => $logistik_keluar->keterangan,
                "jumlah" => $logistik_keluar->jumlah,
                "id_posko_penerima" => $logistik_keluar->id_posko_penerima,
                "posko_penerima" => $logistik_keluar->posko->nama,
                "status" => $logistik_keluar->status,
                "satuan" => $logistik_keluar->satuan,
                "tanggal" => $logistik_keluar->tanggal,
                "created_at" => $logistik_keluar->created_at,
                "updated_at" => $logistik_keluar->updated_at,
            ];
        }

        return response()->json([
            'message' => 'Berhasil menampilkan data logistik keluar',
            'status' => 200,
            'data' => $results
        ],200);
    }

    public function tambahLogistikKeluar(Request $request){
        $rules = [
            'jenis_kebutuhan' => 'required',
            'keterangan' => 'required',
            'jumlah' => 'required',
            'id_posko_penerima' => 'required',
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
            'jenis_kebutuhan' => $request->jenis_kebutuhan,
            'keterangan' => $request->keterangan,
            'jumlah' => $request->jumlah,
            'id_posko_penerima' => $request->id_posko_penerima,
            'status' => $request->status,
            'satuan' => $request->satuan,
            'tanggal' => $request->tanggal
        ]);

        return response()->json([
            'message' => 'Berhasil menambahkan data logistik keluar',
            'status' => 200,
            'data' => $data_logistik_keluar
        ], 200);
    }

    public function ubahLogistikKeluar(Request $request, $id){
        $data_logistik_keluar = LogistikKeluar::findOrFail($id);

        $data_logistik_keluar->update([
            'jenis_kebutuhan' => $request->jenis_kebutuhan,
            'keterangan' => $request->keterangan,
            'jumlah' => $request->jumlah,
            'id_posko_penerima' => $request->id_posko_penerima,
            'status' => $request->status,
            'satuan' => $request->satuan,
            'tanggal' => $request->tanggal
        ]);

        return response()->json([
            'message' => 'Berhasil mengubah data logistik keluar',
            'status' => 200,
            'data' => $data_logistik_keluar
        ], 200);
    }

    public function hapusLogistikKeluar($id) {
        $data_logistik_keluar = LogistikKeluar::findOrFail($id);

        $data_logistik_keluar->delete();

        return response()->json([
            'message' => 'Berhasil hapus data logistik keluar',
            'status' => 200,
            'data' => $data_logistik_keluar
        ], 200);
    }
}
