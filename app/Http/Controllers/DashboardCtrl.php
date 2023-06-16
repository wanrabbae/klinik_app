<?php

namespace App\Http\Controllers;

use App\Models\Pasiens;
use App\Models\Tindakan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardCtrl extends Controller
{
    public function index()
    {
        $data_pasien = Pasiens::all(["id", "nama_pasien", "nomor_rekam_medis", "telepon"]);
        $data_tindakan = Tindakan::all();
        $dateNow = Carbon::now()->format('d/m/Y');
        $data_dokter = User::where('role', 'Dokter')->get(["id", "nama"]);
        return view('dashboard', compact('data_pasien', 'data_tindakan', 'data_dokter', 'dateNow'));
    }
}
