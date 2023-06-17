<?php

namespace App\Http\Controllers;

use App\Models\Tindakan;
use App\Models\User;
use Illuminate\Http\Request;

class InfografisCtrl extends Controller
{
    public function index()
    {
        $data_dokter = User::where("role", "Dokter")->get(["id", "nama"]);
        $data_tindakan = Tindakan::all(["id", "nama_tindakan"]);
        return view('infografis.infografis', compact('data_dokter', 'data_tindakan'));
    }
}
