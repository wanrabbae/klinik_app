<?php

namespace App\Http\Controllers;

use App\Models\Pasiens;
use Illuminate\Http\Request;

class PasienCtrl extends Controller
{
    public function index()
    {
        $data_patients = Pasiens::all();
        return view('pasien.pasien', compact('data_patients'));
    }

    public function preview($id)
    {
        $data_patient = Pasiens::find($id);
        return view('pasien_preview', compact('data_patient'));
    }

    public function store(Request $request)
    {
        Pasiens::create([
            "nama_pasien" => $request->nama_pasien,
            "nomor_rekam_medis" => rand(10000, 99999),
            "telepon" => $request->telepon,
            "alamat" => $request->alamat,
            "tgl_lahir" => $request->tgl_lahir,
            "usia" => $request->usia
        ]);

        return back()->with("success", "Berhasil menambahkan pasien baru");
    }

    public function update(Request $request, $id)
    {
        $patient = Pasiens::find($id);

        if (!$patient) {
            return back()->with("error", "Pasien tidak ditemukan");
        }

        $patient->update([
            "nama_pasien" => $request->nama_pasien,
            "telepon" => $request->telepon,
            "alamat" => $request->alamat,
            "tgl_lahir" => $request->tgl_lahir ?? $patient->tgl_lahir,
            "usia" => $request->usia
        ]);

        return back()->with("success", "Berhasil mengubah pasien");
    }

    public function delete($id)
    {
        $patient = Pasiens::find($id);

        if (!$patient) {
            return back()->with("error", "Pasien tidak ditemukan");
        }

        $patient->destroy($id);

        return back()->with("success", "Berhasil menghapus pasien");
    }
}
