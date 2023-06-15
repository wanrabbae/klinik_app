@extends('templating.template_with_sidebar')

@section('content')
    <h1>Transactions</h1>
    <div class="separator mb-3"></div>
    @if (session()->has('success'))
        <div class="alert alert-info p-2 my-2" role="alert">
            {{ session()->get('success') }}
        </div>
    @endif
    <table id="datatable" class="display nowrap" style="width:100%">
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
                    <td>{{ $transaction->tgl_transaksi }}</td>
                    <td>{{ $transaction->pasien->nama_pasien }}</td>
                    <td>{{ $transaction->dokter->nama }}</td>
                    <td>
                        @if ($transaction->transaction_tindak !== null)
                            @foreach ($transaction->transaction_tindak as $tindakan)
                                <span style="font-size: 12px;">{{ $tindakan->nama_tindakan . ', ' }}</span>
                            @endforeach
                        @else
                            <span></span>
                        @endif
                    </td>
                    <td>{{ $transaction->id }}</td>
                    <td>
                        <a href="{{ route('pasien.preview', $transaction->id) }}" class="btn btn-sm btn-info">Preview</a>
                        <button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modalEditPasien{{ $transaction->id }}">Edit</button>
                        <a href="/transaction/delete/{{ $transaction->id }}" class="btn btn-sm btn-danger" onclick="return confirm('Anda yakin ingin menghapus data ini ?')">Delete</a>
                        <a href="/transaction/delete/{{ $transaction->id }}" class="btn btn-sm btn-primary" onclick="return confirm('Anda yakin ingin menghapus data ini ?')">Nota</a>
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
