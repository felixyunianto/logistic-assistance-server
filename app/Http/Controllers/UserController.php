<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    public function register(Request $request) {
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
            'message' => 'Registrasi berhasil',
            'status' => 200,
            'data' => $respon   
        ], 200);
    }

    public function login(Request $request) {
        $rules = [
            'username' => 'required',
            'password' => 'required'
        ];

        $messages = [
            'required' => ':attribute tidak boleh kosong'
        ];
        $validation = Validator::make($request->all(),$rules, $messages);

        if($validation->fails()) {
            return response()->json([
                'message' => 'Terjadi kesalahan',
                'status' => 401,
                'error' => $validation->errors()
            ], 401);
        }

        if(Auth::attempt(['username' => $request->username,'password' => $request->password])){
            $user = Auth::user();
            $user['token'] = $user->createToken('LogistikBrebes')->accessToken;

            return response()->json([
                'message' => 'Login berhasil',
                'status' => 200,
                'data' => $user
            ]);
        }else{
            return response()->json([
                'message'=>'Login gagal',
                'status' => 401,
                'error' => 'Username or Password is salah'
            ], 401); 
        }
    }
}
