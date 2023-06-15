<?php

namespace App\Http\Controllers;

use App\Models\Transactions;
use App\Models\User;
use Illuminate\Http\Request;

class DokterCtrl extends Controller
{
    public function index()
    {
        $data_dokters = User::with('transaksi')->where('role', '=', 'Dokter')->get();
        $countData = User::count();
        return view('dokter.dokter', compact('data_dokters', 'countData'));
    }

    public function kinerja()
    {
        $data_dokters = User::where('role', 'Dokter')->get(["id", "nama"]);
        return view('dokter.kinerja', compact('data_dokters'));
    }

    public function kinerjaPost(Request $request)
    {
        $data = Transactions::with('dokter', 'pasien', 'transaction_tindak')->where('user_id', '=', $request->dokter)->whereBetween('created_at', [date($request->startDate), date($request->endDate)])->get();

        dd($data);
    }

    public function store(Request $request)
    {
        User::create([
            "nama" => $request->nama_dokter,
            "telepon" => $request->telepon,
            "email" => $request->email,
            "role" => "Dokter",
            "password" => bcrypt($request->password),
            "alamat" => $request->alamat,
            "tgl_lahir" => $request->tgl_lahir,
            "usia" => $request->usia,
        ]);

        return back()->with("success", "Berhasil menambahkan dokter baru");
    }

    public function update(Request $request, $id)
    {
        $dokter = User::find($id);

        if (!$dokter) {
            return back()->with("error", "Dokter tidak ditemukan");
        }

        $dokter->update([
            "nama" => $request->nama_dokter,
            "telepon" => $request->telepon,
            "email" => $request->email,
            "password" => $request->password != null ? bcrypt($request->password) : $dokter->password,
            "alamat" => $request->alamat,
            "tgl_lahir" => $request->tgl_lahir ?? $dokter->tgl_lahir,
            "usia" => $request->usia,
        ]);

        return back()->with("success", "Berhasil mengubah dokter");
    }

    public function delete($id)
    {
        $dokter = User::find($id);

        if (!$dokter) {
            return back()->with("error", "Dokter tidak ditemukan");
        }

        $dokter->destroy($id);

        return back()->with("success", "Berhasil menghapus dokter");
    }
}
