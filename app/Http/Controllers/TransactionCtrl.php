<?php

namespace App\Http\Controllers;

use App\Models\Transactions;
use App\Models\TransactionTindakan;
use Illuminate\Http\Request;

class TransactionCtrl extends Controller
{

    public function index()
    {
        $data_transactions = Transactions::with(['pasien', 'dokter', 'transaction_tindak'])->get();
        $countData = Transactions::count();

        if (auth()->user()->role == "Dokter") {
            $data_transactions = Transactions::with(['pasien', 'dokter', 'transaction_tindak'])->where('user_id', auth()->user()->id)->get();

            $countData = Transactions::where('user_id', auth()->user()->id)->count();
        }

        return view('transaction.transaction', compact('data_transactions', 'countData'));
    }

    public function store(Request $request)
    {
        $createTrx = Transactions::create([
            "nomor_transaksi" => $request->nomor_transaksi,
            "patient_id" => intval($request->patient_id),
            "user_id" => intval($request->user_id),
            "keterangan" => $request->keterangan,
        ]);

        if (!$createTrx) {
            return response()->json(["status" => "failed", "message" => "Gagal buat transaksi"], 400);
        }

        if ($request->tindakans) {
            $tindakans = $request->tindakans;
            foreach ($tindakans as $tindak) {
                TransactionTindakan::create([
                    "transaction_id" => $createTrx->id,
                    "nama_tindakan" => $tindak["tindakanInput"],
                    "biaya" => intval($tindak["hargaInput"]),
                    "quantity" => intval($tindak["quantityInput"]),
                    "discount" => intval($tindak["diskonInput"]),
                    "subtotal" => intval($tindak["subTotal"]),
                ]);
            }
        }

        return response()->json($request->all(), 201);
    }
}
