<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Bencana;
use Validator;
use Auth;

class BencanaController extends Controller
{

    public function __construct(){
        $this->middleware('auth:api')->except(['infoBencana']);
    }

    public function infoBencana(){
        $data_bencana = Bencana::orderBy('created_at','DESC')->get();
        return response()->json([
            'message' => 'Berhasil menampilkan data bencana',
            'status' => 200,
            'data' => $data_bencana
        ],200);
    }

    public function tambahBencana(Request $request) {
        $rules = [
            'nama' => 'required',
            'foto' => 'required',
            'detail' => 'required',
            'date' => 'required',
        ];

        $messages = [
            'required' => 'Bidang :attribute tidak boleh kosong'
        ];

        $validation = Validator::make($request->all(), $rules, $messages);

        if($validation->fails()){
            return response()->json([
                'message' => 'Terjadi kesalahan',
                'status' => 401,
                'error' => $validation->errors()
            ], 401);
        }

        if(Auth::user()->level !== 'Admin'){
            return response()->json([
                'message' => 'Terjadi kesalahan',
                'status' => 403,
                'error' => 'Akses ini hanya dimiliki oleh admin'
            ],403);
        }

        $data_bencana = Bencana::create([
            'nama' => $request->nama,
            'foto' => $request->foto,
            'detail' => $request->detail,
            'date' => $request->date,
        ]);

        return response()->json([
            'message' => 'Berhasil menambahkan data bencana',
            'status' => 200,
            'data' => $data_bencana
        ],200);
    }

    public function ubahBencana(Request $request, $id) {
        if(Auth::user()->level !== 'Admin'){
            return response()->json([
                'message' => 'Terjadi kesalahan',
                'status' => 403,
                'error' => 'Akses ini hanya dimiliki oleh admin'
            ],403);
        }

        $data_bencana = Bencana::findOrFail($id);
        $data_bencana->update([
            'nama' => $request->nama,
            'foto' => $request->foto,
            'detail' => $request->detail,
            'date' => $request->date,
        ]);

        return response()->json([
            'message' => 'Berhasil mengubah data bencana',
            'status' => 200,
            'data' => $data_bencana
        ],200);
    }
    
    public function hapusBencana($id){
        if(Auth::user()->level !== 'Admin'){
            return response()->json([
                'message' => 'Terjadi kesalahan',
                'status' => 403,
                'error' => 'Akses ini hanya dimiliki oleh admin'
            ]);
        }

        $data_bencana = Bencana::findOrFail($id);
        $data_bencana->delete();

        return response()->json([
            'message' => 'Berhasil menghapus data bencana',
            'status' => 200,
            'data' => $data_bencana
        ],200);
    }
}
