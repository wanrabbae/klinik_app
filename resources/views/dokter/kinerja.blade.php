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
            <form action="/lapor_kinerja" method="post">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group mb-3">
                            <label for="Pilih Dokter">Pilih Dokter</label>
                            <select name="dokter" id="dokter" class="form-control">
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
                                    <input type="date" class="form-control" placeholder="Tanggal Awal" name="startDate">
                                </div>

                                <div class="col-md-6">
                                    <input type="date" class="form-control" placeholder="Tanggal Akhir" name="endDate">
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

    <div class="card mt-3">
        <div class="card-body">
            <table border="1" cellspacing="0">
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
                        <th scope="col">Total</th>
                        <th scope="col">Jasa Medis</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th rowspan="10">29/03/2023</th>
                    </tr>
                    <tr>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>Otto</td>
                        <td>Otto</td>
                        <td>Otto</td>
                        <td>Otto</td>
                        <td>Otto</td>
                        <td>Otto</td>
                        <td>Otto</td>
                    </tr>
                    <tr>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>Otto</td>
                        <td>Otto</td>
                        <td>Otto</td>
                        <td>Otto</td>
                        <td>Otto</td>
                        <td>Otto</td>
                        <td>Otto</td>
                    </tr>
                    <tr>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>Otto</td>
                        <td>Otto</td>
                        <td>Otto</td>
                        <td>Otto</td>
                        <td>Otto</td>
                        <td>Otto</td>
                        <td>Otto</td>
                    </tr>
                    <tr>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>Otto</td>
                        <td>Otto</td>
                        <td>Otto</td>
                        <td>Otto</td>
                        <td>Otto</td>
                        <td>Otto</td>
                        <td>Otto</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
