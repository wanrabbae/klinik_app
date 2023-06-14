<?php

namespace App\Http\Controllers;

use App\Models\Tindakan;
use Illuminate\Http\Request;

class TindakanCtrl extends Controller
{
    public function index()
    {
        $data_tindakans = Tindakan::all();
        $countData = Tindakan::count();
        return view('tindakan.tindakan', compact('data_tindakans', 'countData'));
    }

    public function store(Request $request)
    {
        Tindakan::create([
            "nama_tindakan" => $request->nama_tindakan,
            "satuan" => $request->satuan,
            "jasa_medis" => $request->jasa_medis,
            "bhp" => $request->bhp,
            "total_harga" => intval($request->jasa_medis) + intval($request->bhp),
            "keterangan" => $request->keterangan
        ]);

        return back()->with("success", "Berhasil menambahkan tindakan baru");
    }

    public function update(Request $request, $id)
    {
        $tindakan = Tindakan::find($id);

        if (!$tindakan) {
            return back()->with("error", "Tindakan tidak ditemukan");
        }

        $tindakan->update([
            "nama_tindakan" => $request->nama_tindakan,
            "satuan" => $request->satuan,
            "jasa_medis" => $request->jasa_medis,
            "bhp" => $request->bhp,
            "total_harga" => intval($request->jasa_medis) + intval($request->bhp),
            "keterangan" => $request->keterangan
        ]);

        return back()->with("success", "Berhasil mengubah tindakan");
    }

    public function delete($id)
    {
        $tindakan = Tindakan::find($id);

        if (!$tindakan) {
            return back()->with("error", "Tindakan tidak ditemukan");
        }

        $tindakan->destroy($id);

        return back()->with("success", "Berhasil menghapus tindakan");
    }
}
