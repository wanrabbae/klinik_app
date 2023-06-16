<?php

namespace App\Http\Controllers;

use App\Models\Tindakan;
use App\Models\Transactions;
use App\Models\TransactionTindakan;
use Illuminate\Http\Request;

class TransactionCtrl extends Controller
{

    public function index()
    {
        $data_transactions = Transactions::with(['pasien', 'dokter', 'transaction_tindak', 'transaction_tindak.tindakan'])->get();
        $countData = Transactions::count();

        if (auth()->user()->role == "Dokter") {
            $data_transactions = Transactions::with(['pasien', 'dokter', 'transaction_tindak', 'transaction_tindak.tindakan'])->where('user_id', auth()->user()->id)->get();

            $countData = Transactions::where('user_id', auth()->user()->id)->count();
        }

        return view('transaction.transaction', compact('data_transactions', 'countData'));
    }

    public function destroy($id)
    {
        $transaction = Transactions::find($id);

        if (!$transaction) {
            return back()->with("error", "Transaction tidak ditemukan");
        }

        $transaction->destroy($id);
        return back()->with('success', 'Berhasil menghapus transaksi');
    }

    public function preview(Request $request)
    {
        $transaction = Transactions::with(['pasien', 'dokter', 'transaction_tindak', 'transaction_tindak.tindakan'])->where('id', $request->query('id'))->first();
        $data_tindakan = Tindakan::all(["id", "nama_tindakan", "total_harga"]);

        if (!$transaction) {
            return back()->with("error", "Transaction tidak ditemukan");
        }

        return view('transaction.transaction_preview', compact('transaction', 'data_tindakan'));
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
                    "tindakan_id" => intval($tindak["tindakanInput"]),
                    "biaya" => intval($tindak["hargaInput"]),
                    "quantity" => intval($tindak["quantityInput"]),
                    "discount" => intval($tindak["diskonInput"]),
                    "subtotal" => intval($tindak["subTotal"]),
                ]);
            }
        }

        return response()->json($request->all(), 201);
    }

    // TRANSACTION TINDAKAN CTRL

    public function createTindakan(Request $request)
    {
        $subtotal = intval($request->biaya) * intval($request->quantity);

        if ($request->diskon) {
            $diskonAmount = ($subtotal * intval($request->diskon)) / 100;
            $subtotal = $subtotal - $diskonAmount;
        }

        $transaction = TransactionTindakan::create([
            "transaction_id" => $request->trx_id,
            "tindakan_id" => explode("-", $request->tindakan_id)[0],
            "biaya" => $request->biaya,
            "quantity" => $request->quantity,
            "discount" => $request->diskon,
            "subtotal" => $subtotal,
        ]);

        return back()->with('success', 'Berhasil menambahkan tindakan');
    }

    public function editTindakan(Request $request)
    {
        $tindakan = TransactionTindakan::find($request->tindakan_id);

        $subtotal = $tindakan->biaya * intval($request->quantity);
        $diskonAmount = ($subtotal * intval($request->diskon)) / 100;
        $subtotal = $subtotal - $diskonAmount;

        $tindakan->update([
            "quantity" => $request->quantity,
            "discount" => $request->diskon,
            "subtotal" => $subtotal,
        ]);

        return back()->with('success', 'Berhasil mengedit tindakan');
    }

    public function destroyTindakan($id)
    {
        $transaction = TransactionTindakan::find($id);

        if (!$transaction) {
            return back()->with("error", "Tindakan tidak ditemukan");
        }

        $transaction->destroy($id);
        return back()->with('success', 'Berhasil menghapus tindakan');
    }

    // BACKUP EDIT TINDAKAN (DONT REMOVE!)
    // public function editTindakan(Request $request)
    // {
    //     $tindakan = TransactionTindakan::find($request->tindakan_id);

    //     if ($request->quantity && $request->diskon) {
    //         $subtotal = $tindakan->biaya * intval($request->quantity);
    //         $diskonAmount = ($subtotal * intval($request->diskon)) / 100;
    //         $subtotal = $subtotal - $diskonAmount;

    //         $tindakan->update([
    //             "quantity" => $request->quantity,
    //             "discount" => $request->diskon,
    //             "subtotal" => $subtotal,
    //         ]);

    //         return back()->with('success', 'Berhasil mengedit tindakan');
    //     } else if ($request->quantity && $request->quantity != 0) {
    //         $subtotal = $tindakan->biaya * intval($request->quantity);
    //         $tindakan->update([
    //             "quantity" => $request->quantity,
    //             "discount" => $request->diskon,
    //             "subtotal" => $subtotal,
    //         ]);
    //     } else if ($request->diskon && $request->diskon != 0) {
    //         dd("KE ELIF 2");
    //     } else {
    //         return back()->with("error", "Warning!");
    //     }

    //     return back()->with('success', 'Berhasil menambahkan tindakan');
    // }
}
