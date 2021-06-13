<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\User;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{

    public function __construct(){
        $this->middleware('auth:api')->except('tambahPetugasPosko');
    }

    public function infoPetugasPosko() {
        if(Auth::user()->level !== 'Admin'){
            return response()->json([
                'message' => 'Terjadi kesalahan',
                'status' => 403,
                'error' => 'Akses ini hanya dimiliki oleh admin'
            ],403);
        }

        $data_petugas_posko = User::where('level', 'Petugas')->orderBy('nama', 'ASC')->get();

        return response()->json([
            'message' => 'Berhasil menampilkan data petugas posko',
            'status' => 200,
            'data' => $data_petugas_posko
        ],200);
    }

    public function tambahPetugasPosko(Request $request) {
        $validation = Validator::make($request->all(), [
            'nama' => 'required',
            'username' => 'required | unique:users',
            'password' => 'required | min: 6',
            'konfirmasi_password' => 'required | same:password',
            'level' => 'required'
        ], [
            'required' => ':attribute tidak boleh kosong',
            'unique' => ':attribute sudah digunakan oleh user lain',
            'min' => ':attribute mininal :min karakter',
            'same' => ':attribute tidak sama'
        ]);

        if($validation->fails()) {
            return response()->json([
                'message' => 'Terjadi kesalahan',
                'status' => 401,
                'error' => $validation->errors()
            ], 401);
        }

        $username = User::where('username', $request->username)->first();
        

        if($username !== null){
            return response()->json([
                'message' => 'Terjadi kesalahan',
                'status' => 422,
                'error' => 'Username telah digunakan oleh user lain'
            ], 402);
        }

        $user = User::create([
            'nama' => $request->nama,
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'level' => $request->level,
            'id_posko' => $request->id_posko,
        ]);

        $respon = [
            'nama' => $user['nama'],
            'username' => $user['username'],
            'level' => $user['level'],
            'token' => $user->createToken('LogistikBrebes')->accessToken,
        ];

        return response()->json([
            'message' => 'Berhasil menambahkan petugas posko',
            'status' => 200,
            'data' => $respon   
        ], 200);
    }

    public function ubahPetugasPosko(Request $request, $id){
        if(Auth::user()->level !== 'Admin'){
            return response()->json([
                'message' => 'Terjadi kesalahan',
                'status' => 403,
                'error' => 'Akses ini hanya dimiliki oleh admin'
            ],403);
        }

        $data_petugas_posko = User::findOrFail($id);
        $data_petugas_posko->update([
            'nama' => $request->nama,
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'level' => $request->level,
            'id_posko' => $request->id_posko,
        ]);

        return response()->json([
            'message' => 'Berhasil mengubah data petugas posko',
            'status' => 200,
            'data' => $data_petugas_posko
        ], 200);
    }

    public function hapusPetugasPosko($id) {
        if(Auth::user()->level !== 'Admin'){
            return response()->json([
                'message' => 'Terjadi kesalahan',
                'status' => 403,
                'error' => 'Akses ini hanya dimiliki oleh admin'
            ],403);
        }
        
        $data_petugas_posko = User::findOrFail($id);
        $data_petugas_posko->delete();

        return response()->json([
            'message' => 'Berhasil menghapus data petugas posko',
            'status' => 200,
            'data' => $data_petugas_posko
        ], 200);
    }

    
}
