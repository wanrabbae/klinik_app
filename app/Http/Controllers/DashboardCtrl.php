<?php

namespace App\Http\Controllers;

use App\Models\Pasiens;
use App\Models\Tindakan;
use Illuminate\Http\Request;

class DashboardCtrl extends Controller
{
    public function index()
    {
        $data_pasien = Pasiens::all(["id", "nama_pasien", "nomor_rekam_medis", "telepon"]);
        $data_tindakan = Tindakan::all();
        return view('dashboard', compact('data_pasien', 'data_tindakan'));
    }
}
