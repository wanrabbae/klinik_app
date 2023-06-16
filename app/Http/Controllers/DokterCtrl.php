<?php

namespace App\Http\Controllers;

use App\Models\Transactions;
use App\Models\User;
use Carbon\Carbon;
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
        $data_kinerja = null;
        $data_dokters = User::where('role', 'Dokter')->get(["id", "nama"]);
        return view('dokter.kinerja', compact('data_dokters', 'data_kinerja'));
    }

    public function kinerjaPost(Request $request)
    {
        $data_kinerja = Transactions::with('dokter', 'pasien', 'transaction_tindak', 'transaction_tindak.tindakan')->where('user_id', '=', $request->dokter)->whereBetween('created_at', [date($request->startDate), date($request->endDate)])->get();
        $total = 0;
        $dataInfo = [];

        if ($request->dokter && $request->startDate && $request->endDate) {
            $dokter = User::find($request->dokter);
            $dataInfo = [
                "nama_dokter" => $dokter->nama,
                "dokter_id" => $dokter->id,
                "startDate" => Carbon::parse($request->startDate)->format('d-F-Y'),
                "endDate" => Carbon::parse($request->endDate)->format('d-F-Y'),
                "startDate2" => $request->startDate,
                "endDate2" => $request->endDate,
            ];
        }

        foreach ($data_kinerja as $transaction) {
            foreach ($transaction->transaction_tindak as $tindakan) {
                $total += $tindakan->subtotal;
            }
        }

        $data_dokters = User::where('role', 'Dokter')->get(["id", "nama"]);
        return view('dokter.kinerja', compact('data_dokters', 'data_kinerja', 'dataInfo', 'total'));
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
