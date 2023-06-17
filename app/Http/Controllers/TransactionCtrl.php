<?php

namespace App\Http\Controllers;

use App\Models\Tindakan;
use App\Models\Transactions;
use App\Models\TransactionTindakan;
use Carbon\Carbon;
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

    public function updateKeterangan(Request $request, $id)
    {
        $createTrx = Transactions::find($id);

        if (!$createTrx) {
            return back()->with('error', 'Transaksi tidak ditemukan');
        }

        $createTrx->update([
            "keterangan" => $request->keterangan,
        ]);

        return back()->with('success', 'Berhasil update keterangan!');
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

    public function transactionInOneYear()
    {
        $data_transactions = Transactions::all();

        return response()->json($data_transactions);
    }

    public function transactionByDokter(Request $request)
    {
        $data_transactions = Transactions::with(['dokter'])->whereBetween('created_at', [date("Y-m-d", strtotime("-7 days")), date("Y-m-d", strtotime("+1 day"))])->orderBy('created_at')->get()->groupBy(function ($item) {
            return Carbon::parse($item->created_at)->format('d-F-Y');
        });

        if ($request->has('dokter') && $request->has('startDate') && $request->has('endDate')) {
            $dokter = $request->query('dokter');
            $data_transactions = Transactions::with(['dokter' => function ($query) use ($dokter) {
                $query->where('nama', '=', $dokter);
            }])->whereBetween('created_at', [date($request->query('startDate')), date($request->query('endDate'), strtotime("+1 day"))])->orderBy('created_at')->get()->groupBy(function ($item) {
                return Carbon::parse($item->created_at)->format('d-F-Y');
            });
        } else if ($request->has('startDate') && $request->has('endDate')) {
            $data_transactions = Transactions::with(['dokter'])->whereBetween('created_at', [date($request->query('startDate')), date($request->query('endDate'), strtotime("+1 day"))])->orderBy('created_at')->get()->groupBy(function ($item) {
                return Carbon::parse($item->created_at)->format('d-F-Y');
            });
        }

        return response()->json($data_transactions);
    }

    public function transactionByTindakan(Request $request)
    {
        $data_transactions = TransactionTindakan::with(['tindakan'])->whereBetween('created_at', [date("Y-m-d", strtotime("-7 days")), date("Y-m-d", strtotime("+1 day"))])->orderBy('created_at')->get()->groupBy(function ($item) {
            return Carbon::parse($item->created_at)->format('d-F-Y');
        });

        if ($request->has('tindakan') && $request->has('startDate') && $request->has('endDate')) {
            $tindakan = $request->query('tindakan');
            $data_transactions = TransactionTindakan::with(['tindakan' => function ($query) use ($tindakan) {
                $query->where('nama_tindakan', '=', $tindakan);
            }])->whereBetween('created_at', [date($request->query('startDate')), date($request->query('endDate'), strtotime("+1 day"))])->orderBy('created_at')->get()->groupBy(function ($item) {
                return Carbon::parse($item->created_at)->format('d-F-Y');
            });
        } else if ($request->has('startDate') && $request->has('endDate')) {
            $data_transactions = TransactionTindakan::with(['tindakan'])->whereBetween('created_at', [date($request->query('startDate')), date($request->query('endDate'), strtotime("+1 day"))])->orderBy('created_at')->get()->groupBy(function ($item) {
                return Carbon::parse($item->created_at)->format('d-F-Y');
            });
        }

        return response()->json($data_transactions);
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
