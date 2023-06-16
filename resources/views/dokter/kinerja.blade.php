@extends('templating.template_with_sidebar')
<style>
    table {
        width: 100%;
    }

    th,
    td {
        border: 1px solid black;
        text-align: center;
        padding: 10px;
    }
</style>
@section('content')
    <h1>Kinerja Dokter</h1>
    <div class="separator mb-3"></div>
    <div class="card">
        <div class="card-body">
            <form action="/lapor_kinerja" method="get">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group mb-3">
                            <label for="Pilih Dokter">Pilih Dokter</label>
                            <select required name="dokter" id="dokter" class="form-control">
                                <option value="" selected>Pilih Dokter</option>
                                @foreach ($data_dokters as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group mb-3">
                            <label for="Pilih Dokter">Rentang Tanggal</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <input required type="date" class="form-control" placeholder="Tanggal Awal" name="startDate">
                                </div>

                                <div class="col-md-6">
                                    <input required type="date" class="form-control" placeholder="Tanggal Akhir" name="endDate">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-lg btn-primary">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if ($data_kinerja != null)
        <div class="card mt-3">
            <div class="card-body">
                <div class="card-title">
                    Laporan Kinerja Dokter {{ $dataInfo['nama_dokter'] }}, di rentang tanggal {{ $dataInfo['startDate'] }} hingga {{ $dataInfo['endDate'] }}
                </div>
                <table border="1" cellspacing="0" id="table_kinerja">
                    <thead>
                        <tr>
                            <th scope="col">Tanggal</th>
                            <th scope="col">Nomor Transaksi</th>
                            <th scope="col">Nama Pasien</th>
                            <th scope="col">Jenis Tindakan</th>
                            <th scope="col">Jumlah</th>
                            <th scope="col">Harga</th>
                            <th scope="col">Diskon</th>
                            <th scope="col">Subtotal</th>
                            {{-- <th scope="col">Total</th> --}}
                            <th scope="col">Jasa Medis</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data_kinerja as $kinerjas => $data_value)
                            <tr>
                                <th rowspan="{{ count($data_value) + 1 }}">{{ $kinerjas }}</th>
                            </tr>
                            @foreach ($data_value as $transaction)
                                <tr>
                                    <td rowspan="{{ count($transaction->transaction_tindak) + 1 }}">{{ $transaction->nomor_transaksi }}</td>
                                    <td rowspan="{{ count($transaction->transaction_tindak) + 1 }}">{{ $transaction->pasien->nama_pasien }}</td>
                                </tr>
                                @foreach ($transaction->transaction_tindak as $tindakan)
                                    <tr>
                                        <td>{{ $tindakan->tindakan->nama_tindakan }}</td>
                                        <td>{{ $tindakan->quantity }}</td>
                                        <td>{{ $tindakan->biaya }}</td>
                                        <td>{{ $tindakan->discount }}</td>
                                        <td>{{ $tindakan->subtotal }}</td>
                                        {{-- <td>{{ 
                                $tindakan->discount ? $tindakan->quantity * $tindakan-> : 
                            }}</td> --}}
                                        <td>{{ $tindakan->tindakan->jasa_medis }}</td>
                                    </tr>
                                @endforeach
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <span></span>
    @endif
@endsection
