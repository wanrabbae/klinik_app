@extends('templating.template_with_sidebar')
<style>
    /* table, */
    th,
    td {
        border: 1px solid black;
        text-align: center;
        padding: 10px;
    }
</style>
@section('content')
    <h1>Preview Transaksi {{ $transaction->nomor_transaksi }}</h1>
    <div class="separator mb-5"></div>

    @if (session()->has('success'))
        <div class="alert alert-info p-2 my-2" role="alert">
            {{ session()->get('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <p class="text-lg" style="font-size: 18px;">Nomor Transaksi: <strong>{{ $transaction->nomor_transaksi }}</strong></p>
            <p class="text-lg" style="font-size: 18px;">Tanggal Transaksi: <strong>{{ $transaction->created_at->format('d-F-Y') }}</strong></p>
            <p class="text-lg" style="font-size: 18px;">Nama Pasien: <strong>{{ $transaction->pasien->nama_pasien }}</strong></p>
            <p class="text-lg" style="font-size: 18px;">No Rekam Medis: <strong>{{ $transaction->pasien->no_rekam_medis }}</strong></p>
            <p class="text-lg" style="font-size: 18px;">Alamat: <strong>{{ $transaction->pasien->alamat }}</strong></p>
            <p class="text-lg" style="font-size: 18px;">No. Telp: <strong>{{ $transaction->pasien->telepon }}</strong></p>
            <p class="text-lg" style="font-size: 18px;">Transaksi ke: <strong>{{ $transaction->id }}</strong></p>
            <p class="text-lg" style="font-size: 18px;">Dokter Yang Menangani: <strong>{{ $transaction->dokter->nama }}</strong></p>


            {{-- <p class="text-lg" style="font-size: 18px;">Nomor Transaksi:</p>
            <input type="text" class="form-control mb-3" value="{{ $transaction->nomor_transaksi }}">

            <div class="form-group mb-3">
                <p class="text-lg" style="font-size: 18px;">Tanggal Transaksi: </p>
                <input class="form-control" type="text" value="{{ $transaction->created_at->format('d-m-Y') }}">
                <span class="text-muted">Contoh: tanggal-bulan-tahun</span>
            </div>

            <p class="text-lg" style="font-size: 18px;">Nama Pasien: </p>
            <input type="text" class="form-control mb-3" value="{{ $transaction->pasien->nama_pasien }}">

            <p class="text-lg" style="font-size: 18px;">No Rekam Medis:</p>
            <input type="text" class="form-control mb-3" value="{{ $transaction->pasien->nomor_rekam_medis }}">

            <p class="text-lg" style="font-size: 18px;">Alamat:</p>
            <input type="text" class="form-control mb-3" value="{{ $transaction->pasien->alamat }}">

            <p class="text-lg" style="font-size: 18px;">No. Telp: </p>
            <input type="text" class="form-control mb-3" value="{{ $transaction->pasien->telepon }}">

            <p class="text-lg" style="font-size: 18px;">Dokter Yang Menangani:</p>
            <input type="text" class="form-control mb-3" value="{{ $transaction->dokter->nama }}">

            <p class="text-lg" style="font-size: 18px;">Transaksi ke: <strong>{{ $transaction->id }}</strong></p> --}}

            <div class="mt-5">
                <div class="d-flex justify-content-between mb-3 align-items-center">
                    <p class="text-lg" style="font-size: 18px;" class="text-muted">List Tindakan: </p>
                    <button class="btn btn-success">Tambah Tindakan</button>
                </div>

                <table border="1" cellspacing="0" style="width: 100%; text-align: center;">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Qty</th>
                            <th>Biaya</th>
                            <th>Disc (%)</th>
                            <th>Sub Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transaction->transaction_tindak as $tindakan)
                            <tr>
                                <td>{{ $tindakan->tindakan->nama_tindakan }}</td>
                                <td>{{ $tindakan->quantity }}</td>
                                <td>{{ $tindakan->biaya }}</td>
                                <td>{{ $tindakan->discount }}</td>
                                <td>{{ $tindakan->subtotal }}</td>
                                <td>
                                    <button class="btn btn-info">Edit</button>
                                    <a href="/transaction/tindakan/delete/{{ $tindakan->id }}" class="btn btn-danger">Delete</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
