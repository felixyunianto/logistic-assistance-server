<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Penyaluran;
use Validator;

use Cloudinary;
use Carbon\Carbon;

class PenyaluranController extends Controller
{
    public function __construct(){
        $this->middleware("auth:api");
    }

    public function infoPenyaluran(){
        $data_penyaluran = Penyaluran::all();

        return response()->json([
            'message' => 'Berhasil menampilkan data penyaluran logistik',
            'status' => 200,
            'data' => $data_penyaluran
        ],200);
    }

    public function tambahPenyaluran(Request $request){
        $rules = [
            'nama_penerima' => 'required',
            'jenis_kebutuhan' => 'required',
            'jumlah' => 'required',
            'satuan' => 'required',
            'status' => 'required',
            'keterangan' => 'required',
            'alamat' => 'required',
        ];

        $messages = [
            'required' => ':attribute tidak boleh kosong'
        ];

        $validation = Validator::make($request->all(), $rules, $messages);

        if($validation->fails()) {
            return response()->json([
                'message' => 'Terjadi kesalahan',
                'status' => 422,
                'error' => $validation->errors()
            ], 422);
        }

        $fileName = Carbon::now()->format('Y-m-d H:i:s').'-penyaluran-logistik-'.$request->nama_penerima;
        $uploadedFile = $request->file('foto')->storeOnCloudinaryAs('Adit/Bencana',$fileName);

        $foto = $uploadedFile->getSecurePath();
        $public_id = $uploadedFile->getPublicId();

        $data_penyaluran = Penyaluran::create([
            'nama_penerima' => $request->nama_penerima,
            'jenis_kebutuhan' => $request->jenis_kebutuhan,
            'jumlah' => $request->jumlah,
            'satuan' => $request->satuan,
            'status' => $request->status,
            'keterangan' => $request->keterangan,
            'alamat' => $request->alamat,
            'foto' => $request->foto ? $foto : null,
            'public_id' => $request->foto ? $public_id : null,
            'tanggal' => $request->tanggal,
        ]);

        return response()->json([
            'message' => 'Berhasil menambahkan penyaluran logistik',
            'status' => 200,
            'data' => $data_penyaluran
        ], 200);
    }

    public function ubahPenyaluran(Request $request, $id){
        $data_penyaluran = Penyaluran::findOrFail($id);

        if($request->foto){
            $fileName = Carbon::now()->format('Y-m-d H:i:s').'-penyaluran-logistik-'.$request->nama_penerima;
            
            if($data_penyaluran->public_id != null){
                Cloudinary::destroy($data_penyaluran->public_id);
            }

            $uploadedFile = $request->file('foto')->storeOnCloudinaryAs('Adit/Bencana',$fileName);

            $foto = $uploadedFile->getSecurePath();
            $public_id = $uploadedFile->getPublicId();
        }

        $data_penyaluran->update([

            'nama_penerima' => $request->nama_penerima,
            'jenis_kebutuhan' => $request->jenis_kebutuhan,
            'jumlah' => $request->jumlah,
            'satuan' => $request->satuan,
            'status' => $request->status,
            'keterangan' => $request->keterangan,
            'alamat' => $request->alamat,
            'foto' => $request->foto ? $foto : $data_penyaluran->foto,
            'public_id' => $request->foto ? $public_id : $data_penyaluran->public_id,
            'tanggal' => $request->tanggal,
        ]);

        return response()->json([
            'message' => 'Berhasil mengubah penyaluran logistik',
            'status' => 200,
            'data' => $data_penyaluran
        ], 200);
    }


    public function hapusPenyaluran($id){
        $data_penyaluran = Penyaluran::findOrFail($id);
        if($data_penyaluran->public_id != null){
            Cloudinary::destroy($data_penyaluran->public_id);
        }

        $data_penyaluran->delete();

        return response()->json([
            'message' => 'Berhasil menghapus penyaluran logistik',
            'status' => 200,
            'data' => $data_penyaluran
        ], 200);        
    }
}
