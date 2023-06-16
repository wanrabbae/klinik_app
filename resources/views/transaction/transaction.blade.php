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
                        {{-- <button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modalEditPasien{{ $transaction->id }}">Edit</button> --}}
                        <a href="#" class="btn btn-sm btn-primary" onclick="return confirm('Anda yakin ingin menghapus data ini ?')">Nota</a>
                        <a href="/transaction/delete/{{ $transaction->id }}" class="btn btn-sm btn-danger" onclick="return confirm('Anda yakin ingin menghapus data ini ?')">Delete</a>
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
