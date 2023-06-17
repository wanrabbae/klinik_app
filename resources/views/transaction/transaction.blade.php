@extends('templating.template_with_sidebar', ['isActiveTrx' => 'active'])
<style>
    .inputRange:focus {}

    .inputRange {
        font-size: 15px;
        padding: 5px;
        border: none;
    }
</style>
@section('content')
    <h1>Transactions</h1>
    <div class="separator mb-3"></div>
    @if (session()->has('success'))
        <div class="alert alert-info p-2 my-2" role="alert">
            {{ session()->get('success') }}
        </div>
    @endif

    <div class="mb-3">
        Range Tanggal Transaksi: <input type="text" class="inputRange" id="minDate" placeholder="Dari Tanggal"> - <input type="text" class="inputRange" id="maxDate" placeholder="Sampai Tanggal">
    </div>
    {{-- 
    <table border="0" cellspacing="5" cellpadding="5">
        <tbody>
            <tr>
                <td>Minimum date:</td>
                <td><input type="text" id="minDate" name="min"></td>
            </tr>
            <tr>
                <td>Maximum date:</td>
                <td><input type="text" id="maxDate" name="max"></td>
            </tr>
        </tbody>
    </table> --}}

    <table id="transactions_table" class="display nowrap" style="width:100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Nomor Transaksi</th>
                <th>Tanggal Transaksi</th>
                <th>Nama Pasien</th>
                <th>Dokter</th>
                <th>List Tindakan</th>
                <th>Total</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data_transactions as $transaction)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $transaction->nomor_transaksi }}</td>
                    <td>{{ date('d-F-Y', strtotime($transaction->tgl_transaksi)) }}</td>
                    <td>{{ $transaction->pasien->nama_pasien }}</td>
                    <td>{{ $transaction->dokter->nama }}</td>
                    <td>
                        @if ($transaction->transaction_tindak !== null)
                            @foreach ($transaction->transaction_tindak as $tindakan)
                                <span style="font-size: 12px;">{{ $tindakan->tindakan->nama_tindakan . ', ' }}</span>
                            @endforeach
                        @else
                            <span></span>
                        @endif
                    </td>
                    <td>{{ count($transaction->transaction_tindak) }}</td>
                    <td>
                        <a href="/transaction_preview?id={{ $transaction->id }}" class="btn btn-sm btn-info">Preview</a>
                        <a href="#" id="notaBtn{{ $transaction->id }}" class="btn btn-sm btn-primary" data-nomor_transaksi="{{ $transaction->nomor_transaksi }}"
                            data-tanggal_transaksi="{{ $transaction->tgl_transaksi }}" data-nama_pasien="{{ $transaction->pasien->nama_pasien }}"
                            data-telepon_pasien="{{ $transaction->pasien->telepon }}" data-keterangan="{{ $transaction->keterangan }}" data-data_tindakans="{{ $transaction->transaction_tindak }}"
                            onclick="downloadNota{{ $transaction->id }}()">Nota</a>
                        <a href="/transaction/delete/{{ $transaction->id }}" class="btn btn-sm btn-danger" onclick="return confirm('Anda yakin ingin menghapus data ini ?')">Delete</a>

                        <script>
                            function downloadNota{{ $transaction->id }}() {
                                const notrx = $('#notaBtn{{ $transaction->id }}').data('nomor_transaksi');
                                const tgl_transaksi = $('#notaBtn{{ $transaction->id }}').data('tanggal_transaksi');
                                const nama_pasien = $('#notaBtn{{ $transaction->id }}').data('nama_pasien');
                                const telepon_pasien = $('#notaBtn{{ $transaction->id }}').data('telepon_pasien');
                                const keterangan = $('#notaBtn{{ $transaction->id }}').data('keterangan');
                                const data_tindakans = $('#notaBtn{{ $transaction->id }}').data('data_tindakans');

                                const tindakans = data_tindakans;
                                const totally = tindakans.reduce(function(accumulator, currentValue) {
                                    return accumulator + currentValue.subtotal;
                                }, 0).toString();

                                tindakans.map(tdk => tdk["nama_tindakan"] = tdk["tindakan"]["nama_tindakan"]);

                                fetch(`
                                    /download-nota?tanggal=${tgl_transaksi}
                                    &notrx=${notrx}
                                    &nama_pasien=${nama_pasien}
                                    &keterangan=${keterangan}
                                    &notelp=${telepon_pasien}
                                    &totally=${totally}
        `, {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        },
                                        body: JSON.stringify({
                                            data_tindakan: tindakans
                                        })
                                    })
                                    .then(response => response.blob())
                                    .then(blob => {
                                        // Create a temporary URL for the blob
                                        const url = URL.createObjectURL(blob);

                                        // Create a link element and simulate a click to trigger the download
                                        const a = document.createElement('a');
                                        a.href = url;
                                        a.download = 'file.pdf';
                                        a.style.display = 'none';
                                        document.body.appendChild(a);
                                        a.click();

                                        // Clean up the temporary URL and remove the link element
                                        URL.revokeObjectURL(url);
                                        document.body.removeChild(a);
                                    })
                                    .catch(error => console.error(error));
                            }
                        </script>
                    </td>
                </tr>
            @endforeach

        </tbody>
        <tfoot>
            <tr>
                <th>No</th>
                <th>Nomor Transaksi</th>
                <th>Tanggal Transaksi</th>
                <th>Nama Pasien</th>
                <th>Dokter</th>
                <th>List Tindakan</th>
                <th>Total</th>
                <th>Action</th>
            </tr>
        </tfoot>
    </table>

    <div class="d-flex justify-content-end mt-3">
        <p>Total {{ $countData }} Transaksi</p>
    </div>
@endsection
