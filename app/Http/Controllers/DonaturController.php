<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Donatur;

class DonaturController extends Controller
{
    public function infoDonatur() {
        $data_donatur = Donatur::orderBy('nama')->get();

        return response()->json([
            'message' => 'Berhasil menampilkan data donatur',
            'status' => 200,
            'data' => $data_donatur
        ],200);
    }
}
