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
    <h1>Preview Pasien {{ $data_patient->nama_pasien }}</h1>
    <div class="separator mb-5"></div>

    <div class="card">
        <div class="card-body">
            <p class="fs-5">Nama Pasien: {{ $data_patient->nama_pasien }}</p>
            <p class="fs-5">No Rekam Medis: {{ $data_patient->nomor_rekam_medis }}</p>
            <p class="fs-5">Alamat: {{ $data_patient->alamat }}</p>
            <p class="fs-5">No. Telp: {{ $data_patient->telepon }}</p>
            <p class="fs-5">Tanggal Lahir: {{ $data_patient->tgl_lahir }}</p>
            <p class="fs-5">Jumlah Transaksi: 0</p>

            <div class="mt-2">
                <p class="fs-5" class="text-muted">Rekam Medis</p>

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
                        <tr>
                            <td>23/06/2023</td>
                            <td>Tindakan 1</td>
                            <td>Dokter 1</td>
                            <td>Harus istirahat nonton anime</td>
                        </tr>
                        <tr>
                            <td>23/06/2023</td>
                            <td>Tindakan 1</td>
                            <td>Dokter 1</td>
                            <td>Harus istirahat nonton anime</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
