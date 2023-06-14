<style>
    table {
        width: 100%;
    }

    table tr th {
        border-bottom: 2px solid black;
    }

    .dokterKet {
        width: 300px;
    }
</style>
@extends('templating.template_with_sidebar')
@section('content')
    <h1>Dashboard</h1>
    <div class="separator mb-5"></div>

    <div class="row justify-content-between">
        <div class="col-md-6">
            <h2>Masukkan Tindakan</h2>

            <form method="post" class="card">
                <div class="card-body">
                    <div class="form-group mb-3">
                        <label for="">Nama Pasien</label>
                        <select name="pasien" onchange="pilihPasien()" id="pasien" class="form-control">
                            <option value="">Pilih Pasien</option>
                            @foreach ($data_pasien as $item)
                                <option value="{{ $item->id }}-{{ $item->nama_pasien }}-{{ $item->nomor_rekam_medis }}-{{ $item->telepon }}">{{ $item->nama_pasien }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Nomor Rekam Medis</label>
                        <input type="text" readonly class="form-control" name="nomor_medis" id="nomor_medis">
                    </div>

                    <div class="form-group mb-3">
                        <label for="">Keterangan</label>
                        <textarea onchange="keteranganChange()" class="form-control" name="keterangan" id="keterangan" cols="30" rows="4"></textarea>
                    </div>
                </div>
            </form>
        </div>

        <div class="col-md-6">
            <h2>Tampilan Struk</h2>
            <div class="card rounded-2" id="struk">
                <div class="card-body">
                    <div class="d-flex justify-content-end">
                        <p>Bandung 23/03/2023</p>
                    </div>

                    <div class="d-flex justify-content-between">
                        <p class="fw-bold" style="font-weight: bold;">RINCIAN RAWAT JALAN PASIEN</p>
                        <p>No. <span id="noTrx"></span></p>
                    </div>

                    <div class="d-flex justify-content-between">
                        <p>PRAKTEK DOKTER GIGI SPESIALISTIK</p>
                        <p>Nama Pasien: <span id="pasien_name"></span></p>
                    </div>

                    <div class="d-flex justify-content-between">
                        <p class="mr-2">Jl. Tanjung Sari No.32, Antapani. Bandung 08112276161</p>
                        <p>No telp Pasien: <span id="telp_pasien"></span></p>
                    </div>

                    <div class="my-2">
                        <table cellspacing="5" cellpadding="5">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Tindakan</th>
                                    <th>Qty</th>
                                    <th>Harga</th>
                                    <th>Diskon%</th>
                                    <th>Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    {{-- <td>Tindakan 1</td>
                                    <td>1</td>
                                    <td>100000</td>
                                    <td>10%</td>
                                    <td>90000</td> --}}
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-end">
                        <strong>Total: </strong>
                    </div>

                    <div class="dokterKet">
                        <p>Keterangan Dokter: </p>
                        <p id="keteranganDokter"></p>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div>
                            <p>Perhatian: </p>
                            <p>Kuitansi ini merupakan bukti pembayaran</p>
                        </div>
                        <div class="d-flex flex-column">
                            <p>Hormat Kami, </p>
                            <p style="margin-top: 50px;">(.........................)</p>
                        </div>
                    </div>
                </div>
            </div>

            <center>
                <button id="printPdf" class="btn btn-lg btn-info mt-3" onclick="printDiv('struk')">Download PDF</button>
            </center>
        </div>

        <script>
            const noTrx = document.getElementById('noTrx')
            const pasienChoose = document.getElementById('pasien')
            const nomor_medis = document.getElementById('nomor_medis')
            const pasien_name = document.getElementById('pasien_name')
            const telp_pasien = document.getElementById('telp_pasien')
            const keterangan = document.getElementById('keterangan')
            const keteranganDokter = document.getElementById('keteranganDokter')
            let idPasien

            noTrx.textContent = `DC-${Math.floor(1000000 + Math.random() * 9000000)}`

            function printDiv(divName) {
                var printContents = document.getElementById(divName).innerHTML;
                var originalContents = document.body.innerHTML;

                document.body.innerHTML = printContents;

                window.print();

                document.body.innerHTML = originalContents;
            }

            function pilihPasien() {
                const nomorMedisValue = pasienChoose.value.split("-")[2]
                const namaValue = pasienChoose.value.split("-")[1]
                const idPasienValue = pasienChoose.value.split("-")[0]
                const teleponValue = pasienChoose.value.split("-")[3]
                nomor_medis.value = nomorMedisValue
                pasien_name.textContent = namaValue
                telp_pasien.textContent = teleponValue
                idPasien = idPasienValue
            }

            // function keteranganChange() {
            //     console.log("TEST");
            //     console.log(keterangan.value);
            //     keteranganDokter.textContent = keterangan.value

            // }

            keterangan.addEventListener('input', function(evt) {
                console.log(this.value);
                keteranganDokter.textContent = keterangan.value
            })
        </script>

    </div>
@endsection
