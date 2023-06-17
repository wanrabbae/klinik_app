@extends('templating.template_with_sidebar', ['isActiveTrx' => 'active'])
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

    @if (session()->has('error'))
        <div class="alert alert-danger p-2 my-2" role="alert">
            {{ session()->get('error') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <p class="text-lg" style="font-size: 18px;">Nomor Transaksi: <strong>{{ $transaction->nomor_transaksi }}</strong></p>
            <p class="text-lg" style="font-size: 18px;">Tanggal Transaksi: <strong>{{ $transaction->created_at->format('d-F-Y') }}</strong></p>
            <p class="text-lg" style="font-size: 18px;">Nama Pasien: <strong>{{ $transaction->pasien->nama_pasien }}</strong></p>
            <p class="text-lg" style="font-size: 18px;">No Rekam Medis: <strong>{{ $transaction->pasien->nomor_rekam_medis }}</strong></p>
            <p class="text-lg" style="font-size: 18px;">Alamat: <strong>{{ $transaction->pasien->alamat }}</strong></p>
            <p class="text-lg" style="font-size: 18px;">No. Telp: <strong>{{ $transaction->pasien->telepon }}</strong></p>
            <p class="text-lg" style="font-size: 18px;">Transaksi ke: <strong>{{ $transaction->id }}</strong></p>
            <p class="text-lg" style="font-size: 18px;">Dokter Yang Menangani: <strong>{{ $transaction->dokter->nama }}</strong></p>

            <form action="/tindakan/update-keterangan/{{ $transaction->id }}" method="post">
                @csrf
                <p class="text-lg" style="font-size: 18px;">Keterangan Dokter: </p>
                <textarea name="keterangan" id="keterangan" rows="2" class="form-control mb-2">{{ $transaction->keterangan }}</textarea>
                <button class="btn btn-sm btn-primary mx-auto" type="submit">Ubah Keterangan</button>
            </form>

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
                    <button class="btn btn-success" data-toggle="modal" data-target="#modalCreateTindakan">Tambah Tindakan</button>
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
                                <td>{{ number_format($tindakan->biaya, 0, ',', '.') }}</td>
                                <td>{{ $tindakan->discount }}</td>
                                <td>{{ number_format($tindakan->subtotal, 0, ',', '.') }}</td>
                                <td>
                                    <button class="btn btn-info" data-toggle="modal" data-target="#modalEditTindakan{{ $tindakan->id }}">Edit</button>
                                    <a href="/transaction/tindakan/delete/{{ $tindakan->id }}" class="btn btn-danger" onclick="return confirm('Anda yakin ingin menghapus data ini ?')">Delete</a>


                                    <div class="modal fade" id="modalEditTindakan{{ $tindakan->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Edit Tindakan</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="/transaction/tindakan/edit" method="post">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <input type="hidden" name="tindakan_id" value="{{ $tindakan->id }}">
                                                        <div class="form-group mb-3">
                                                            <label for="" style="text-align: left;">Quantity</label>
                                                            <input class="form-control" name="quantity" type="number" required id="quantityEdit" value="{{ $tindakan->quantity }}" />
                                                        </div>
                                                        <div class="form-group mb-3">
                                                            <label for="">Diskon (%)</label>
                                                            <input class="form-control" name="diskon" type="number" required id="diskonEdit" value="{{ $tindakan->discount }}" />
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalCreateTindakan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Tindakan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="/transaction/tindakan" method="post">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="trx_id" value="{{ $transaction->id }}">
                        <div class="form-group has-float-label mb-3">
                            <label for="">Nama Tindakan</label>
                            <select onchange="assignValueTindakan(this)" required class="form-control" name="tindakan_id" id="tindakan_id">
                                <option value="" selected>Pilih Tindakan</option>
                                @foreach ($data_tindakan as $item)
                                    <option value="{{ $item->id }}-{{ $item->nama_tindakan }}-{{ $item->total_harga }}">{{ $item->nama_tindakan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group has-float-label mb-3">
                            <label for="">Biaya</label>
                            <input class="form-control" name="biaya" type="number" required id="biaya" />
                        </div>
                        <div class="form-group has-float-label mb-3">
                            <label for="">Quantity</label>
                            <input class="form-control" name="quantity" type="number" required id="quantity" />
                        </div>
                        <div class="form-group has-float-label mb-3">
                            <label for="">Diskon (%)</label>
                            <input class="form-control" name="diskon" type="number" required id="diskon" />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const biaya = document.getElementById('biaya')

        function assignValueTindakan(selectElement) {
            console.log(selectElement.value);
            biaya.value = selectElement.value.split("-")[2]
        }
    </script>
@endsection
