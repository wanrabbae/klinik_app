@extends('templating.template_with_sidebar', ['isActivePasien' => 'active'])
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
    <h1>Preview Pasien {{ $data_patient->nama_pasien }}</h1>
    <div class="separator mb-5"></div>

    <div class="card">
        <div class="card-body">
            <p class="text-lg" style="font-size: 18px;">Nama Pasien: {{ $data_patient->nama_pasien }}</p>
            <p class="text-lg" style="font-size: 18px;">No Rekam Medis: {{ $data_patient->nomor_rekam_medis }}</p>
            <p class="text-lg" style="font-size: 18px;">Alamat: {{ $data_patient->alamat }}</p>
            <p class="text-lg" style="font-size: 18px;">No. Telp: {{ $data_patient->telepon }}</p>
            <p class="text-lg" style="font-size: 18px;">Tanggal Lahir: {{ explode(' ', $data_patient->tgl_lahir)[0] }}</p>
            <p class="text-lg" style="font-size: 18px;">Jumlah Transaksi: {{ count($data_patient->transactions) ?? 0 }}</p>

            <div class="mt-2">
                <p class="text-lg" style="font-size: 18px;" class="text-muted">Rekam Medis</p>

                <table border="1" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Tindakan</th>
                            <th>Dokter</th>
                            <th>Keterangan Dokter</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($data_patient->transactions != null)
                            @foreach ($data_patient->transactions as $transaction)
                                <tr>
                                    <th rowspan="{{ count($transaction->transaction_tindak) + 1 }}">{{ $transaction->tgl_transaksi }}</th>
                                </tr>
                                @foreach ($transaction->transaction_tindak as $tindakan)
                                    <tr>
                                        <td>{{ $tindakan->tindakan->nama_tindakan }}</td>
                                        <td>{{ $transaction->dokter->nama }}</td>
                                        <td>{{ $transaction->keterangan }}</td>
                                    </tr>
                                @endforeach
                            @endforeach
                        @else
                            <tr>
                                <td colspan="4">Belum Ada Transaksi</td>
                            </tr>
                        @endif

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
