<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LogistikMasuk;
use Validator;

use Cloudinary;
use Carbon\Carbon;

use Auth;

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
            'tanggal' => 'required'
        ];

        $messages = [
            'required' => 'Bidang :attribute tidak boleh kosong',
        ];

        $validation = Validator::make($request->all(), $rules, $messages);

        if(Auth::user()->level !== 'Admin'){
            return response()->json([
                'message' => 'Terjadi kesalahan',
                'status' => 403,
                'error' => 'Akses ini hanya dimiliki oleh admin'
            ],403);
        }

        if($validation->fails()){
            return response()->json([
                'message' => 'Terjadi kesalahan',
                'status' => 403,
                'error' => $validation->errors()
            ]);
        }

        $fileName = Carbon::now()->format('Y-m-d H:i:s').'-'.$request->nama;

        $uploadedFile = $request->file('foto')->storeOnCloudinaryAs('Adit/Bencana',$fileName);

        $foto = $uploadedFile->getSecurePath();
        $public_id = $uploadedFile->getPublicId();

        $data_logistik_masuk = LogistikMasuk::create([
            'jenis_kebutuhan' => $request->jenis_kebutuhan,
            'keterangan' => $request->keterangan,
            'jumlah' => $request->jumlah,
            'pengirim' => $request->pengirim,
            'status' => $request->status,
            'satuan' => $request->satuan,
            'tanggal' => $request->tanggal,
            'foto' => $request->foto ?  $foto : null,
            'public_id' => $request->foto ? $public_id : null
        ]);

        return response()->json([
            'message' => 'Berhasil menambahkan data logistik masuk',
            'status' => 200,
            'data' => $data_logistik_masuk
        ], 200);
    }

    public function ubahLogistikMasuk(Request $request, $id){
        if(Auth::user()->level !== 'Admin'){
            return response()->json([
                'message' => 'Terjadi kesalahan',
                'status' => 403,
                'error' => 'Akses ini hanya dimiliki oleh admin'
            ],403);
        }
        
        $data_logistik_masuk = LogistikMasuk::findOrFail($id);

        if($request->foto){
            $fileName = Carbon::now()->format('Y-m-d H:i:s').'-'.$request->nama;

            if($data_logistik_masuk->public_id){
                Cloudinary::destroy($data_logistik_masuk->public_id);
            }

            $uploadedFile = $request->file('foto')->storeOnCloudinaryAs('Adit/Bencana',$fileName);

            $foto = $uploadedFile->getSecurePath();
            $public_id = $uploadedFile->getPublicId();
        }

        $data_logistik_masuk->update([
            'jenis_kebutuhan' => $request->jenis_kebutuhan,
            'keterangan' => $request->keterangan,
            'jumlah' => $request->jumlah,
            'pengirim' => $request->pengirim,
            'status' => $request->status,
            'satuan' => $request->satuan,
            'tanggal' => $request->tanggal,
            'foto' => $request->foto ?  $foto : $data_logistik_masuk->foto,
            'public_id' => $request->foto ? $public_id : $data_logistik_masuk->public_id
        ]);

        return response()->json([
            'message' => 'Berhasil mengubah data logistik masuk',
            'status' => 200,
            'data' => $data_logistik_masuk
        ], 200);
    }

    public function hapusLogistikMasuk($id) {
        $data_logistik_masuk = LogistikMasuk::findOrFail($id);

        if($data_logistik_masuk->public_id){
            Cloudinary::destroy($data_logistik_masuk->public_id);
        }

        $data_logistik_masuk->delete();

        return response()->json([
            'message' => 'Berhasil hapus data logistik masuk',
            'status' => 200,
            'data' => $data_logistik_masuk
        ], 200);
    }
}
