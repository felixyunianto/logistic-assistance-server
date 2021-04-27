<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PenerimaanLogistik;

class PenerimaanLogistikController extends Controller
{
    public function dataPenerimaanLogistik() {
        $data_penerimaan_logistik = PenerimaanLogistik::orderBy('tanggal')->get();
        
        return response()->json([
            'message' => 'Berhasil menampilkan data penerimaan logistik',
            'status' => 200,
            'data' => $data_penerimaan_logistik
        ],200);
    }
}
