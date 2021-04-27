<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Bencana;

class BencanaController extends Controller
{
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

        $this->validate($request, $rules, $messages);

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
    
}
