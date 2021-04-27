<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Posko;

class PoskoController extends Controller
{
    public function infoPosko() {
        $data_posko = Posko::orderBy('nama')->get();

        return response()->json([
            'message' => 'Berhasil menampilkan data posko',
            'status' => 200,
            'data' => $data_posko
        ],200);
    }
}
