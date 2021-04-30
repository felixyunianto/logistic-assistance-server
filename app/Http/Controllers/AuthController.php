<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
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
