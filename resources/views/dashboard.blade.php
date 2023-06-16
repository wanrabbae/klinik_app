<style>
    @media print {
        @page {
            size: 8.5in 11in;
        }
    }

    table {
        width: 100%;
        font-size: 10px;
    }


    table tr th {
        border-bottom: 2px solid black;
    }

    .dokterKet {
        width: 300px;
    }
</style>
@extends('templating.template_with_sidebar', ['isActiveDashboard' => 'active'])
@section('content')
    <h1>Dashboard</h1>
    <div class="separator mb-5"></div>
    <div id="showAlert">

    </div>
    <div class="row justify-content-between">
        <div class="col-md-6">
            <h2>Masukkan Tindakan</h2>

            <form method="post" class="card" id="createTransaction">
                <div class="card-body">
                    <div class="form-group mb-3">
                        <label for="">Nama Pasien</label>
                        <select name="pasien" required onchange="pilihPasien()" id="pasien" class="form-control">
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
                        <label for="">Dokter</label>
                        <select name="dokter_plih" required id="dokter_pilih" class="form-control">
                            @if (auth()->user()->role == 'Dokter')
                                <option value="{{ auth()->user()->id }}" selected>{{ auth()->user()->nama }}</option>
                            @else
                                <option value="" selected>Pilih Dokter</option>
                                @foreach ($data_dokter as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label for="">Keterangan</label>
                        <textarea class="form-control" name="keterangan" id="keterangan" cols="30" rows="4"></textarea>
                    </div>

                    {{-- TINDAKAN --}}
                    <div class="tindakanList" id="tindakanList">
                        <div class="form-row d-flex align-items-center">
                            <div>
                                <div class="form-group mb-3">
                                    <label for="">Tindakan</label>
                                    <select name="tindakan[]" id="tindakan" onchange="assignValueTindakan(this)" class="form-control form-select">
                                        <option value="">Pilih Tindakan</option>
                                        @foreach ($data_tindakan as $item)
                                            <option value="{{ $item->id }}-{{ $item->nama_tindakan }}-{{ $item->total_harga }}">{{ $item->nama_tindakan }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="d-flex align-items-center mb-3">
                                    <div class="mr-2">
                                        <label for="">Harga</label>
                                        <input type="number" id="hargaFirst" name="harga[]" class="form-control form-input">
                                    </div>
                                    <div class="mr-2">
                                        <label for="">Quantity</label>
                                        <input type="number" required name="quantity[]" class="form-control form-input">
                                    </div>
                                    <div class="mr-2">
                                        <label for="">Diskon (%)</label>
                                        <input type="number" name="diskon[]" class="form-control form-input">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="button" id="tambahTindakan" onclick="addRow()" class="btn btn-primary">+</button>
                    </div>
                </div>
                <center>
                    <button type="submit" class="btn btn-lg btn-primary mb-3">Buat Tindakan</button>
                    <button type="button" onclick="previewAction()" class="btn btn-lg btn-outline-warning mb-3">Preview</button>
                </center>
            </form>

        </div>

        <div class="col-md-6">
            <h2>Preview Struk</h2>
            <div class="card rounded-2">
                <div id="editor"></div>
                <div class="card-body struk" id="struk">
                    <div class="d-flex justify-content-end">
                        <p style="font-size: 10px">Bandung {{ $dateNow }}</p>
                    </div>

                    <div class="d-flex justify-content-between">
                        <p style="font-size: 10px; font-weight: bold;">RINCIAN RAWAT JALAN PASIEN</p>
                        <p style="font-size: 10px">No. <span id="noTrx"></span></p>
                    </div>

                    <div class="d-flex justify-content-between">
                        <p style="font-size: 10px">PRAKTEK DOKTER GIGI SPESIALISTIK</p>
                        <p style="font-size: 10px">Nama Pasien: <span id="pasien_name"></span></p>
                    </div>

                    <div class="d-flex justify-content-between">
                        <p style="font-size: 10px" class="mr-2">Jl. Tanjung Sari No.32, Antapani. Bandung 08112276161</p>
                        <p style="font-size: 10px">No telp Pasien: <span id="telp_pasien"></span></p>
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
                            <tbody id="rowTindakan">

                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-end">
                        <strong>Total: <span id="totalJumlah"></span></strong>
                    </div>

                    <div class="dokterKet">
                        <p style="font-size: 10px">Keterangan Dokter: </p>
                        <p style="font-size: 10px" id="keteranganDokter"></p>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div>
                            <p style="font-size: 10px">Perhatian: </p>
                            <p style="font-size: 10px">Kuitansi ini merupakan bukti pembayaran</p>
                        </div>
                        <div class="d-flex flex-column">
                            <p style="font-size: 10px">Hormat Kami, </p>
                            <p style="font-size: 10px" style="margin-top: 50px;">(.........................)</p>
                        </div>
                    </div>
                </div>
                <center>
                    <button id="downloadButton" class="btn btn-lg btn-info my-3">Download PDF</button>
                </center>
            </div>


        </div>

        <script>
            const noTrx = document.getElementById('noTrx')
            const pasienChoose = document.getElementById('pasien')
            const nomor_medis = document.getElementById('nomor_medis')
            const pasien_name = document.getElementById('pasien_name')
            const dokter_pilih = document.getElementById('dokter_pilih')
            const telp_pasien = document.getElementById('telp_pasien')
            const keterangan = document.getElementById('keterangan')
            const keteranganDokter = document.getElementById('keteranganDokter')
            let idPasien
            const tindakanShow = document.getElementById('tindakanList')
            const rowTindakan = document.getElementById('rowTindakan')
            const totalJumlah = document.getElementById('totalJumlah')

            const createTransaction = document.getElementById('createTransaction')

            const listTindakanData = new Array()
            let tindakanDataValues = []

            <?php foreach($data_tindakan as $key => $val) { ?>
            listTindakanData.push('<?php echo $val; ?>');
            <?php } ?>


            function addRow() {
                var formContainer = tindakanShow;

                var wrapperFormMain = document.createElement("div")
                wrapperFormMain.className = "form-row d-flex align-items-center"

                var wrapperForm = document.createElement("div")
                wrapperForm.style.width = "90%"

                var formRow = document.createElement("div");
                formRow.className = "form-group mb-3";

                var formRow2 = document.createElement("div");
                formRow2.className = "d-flex align-items-center mb-3";

                var labelTindakan = document.createElement("label")

                labelTindakan.textContent = "Tindakan"

                var selectTindakan = document.createElement("select")
                selectTindakan.name = "tindakan[]"
                selectTindakan.className = "form-control"
                selectTindakan.onchange = function() {
                    assignValueTindakan(this);
                };

                var optionTindakanPlaceHolder = document.createElement("option");
                optionTindakanPlaceHolder.textContent = "Pilih Tindakan"
                optionTindakanPlaceHolder.value = ""

                selectTindakan.appendChild(optionTindakanPlaceHolder);

                listTindakanData.map(tindak => {
                    tindak = JSON.parse(tindak)
                    var optionTindakan = document.createElement("option");
                    optionTindakan.value = tindak.id + "-" + tindak.nama_tindakan + "-" + tindak.total_harga;
                    optionTindakan.textContent = tindak.nama_tindakan;
                    selectTindakan.appendChild(optionTindakan);
                })

                var wrapperInputHarga = document.createElement("div")
                wrapperInputHarga.className = "mr-2"

                var labelHargaInput = document.createElement("label")
                labelHargaInput.textContent = "Harga"

                var hargaInput = document.createElement("input");
                hargaInput.type = "number";
                hargaInput.className = "form-control";
                hargaInput.name = "harga[]";
                // hargaInput.readOnly = true;

                wrapperInputHarga.appendChild(labelHargaInput)
                wrapperInputHarga.appendChild(hargaInput)

                var wrapperInputQuantity = document.createElement("div")
                wrapperInputQuantity.className = "mr-2"

                var labelQuantityInput = document.createElement("label")
                labelQuantityInput.textContent = "Quantity"

                var QuantityInput = document.createElement("input");
                QuantityInput.className = "form-control";
                QuantityInput.name = "quantity[]";
                QuantityInput.type = "number";
                QuantityInput.required = true;

                wrapperInputQuantity.appendChild(labelQuantityInput)
                wrapperInputQuantity.appendChild(QuantityInput)

                var wrapperInputDiskon = document.createElement("div")
                wrapperInputDiskon.className = "mr-2"

                var labelDiskonInput = document.createElement("label")
                labelDiskonInput.textContent = "Diskon (%)"

                var DiskonInput = document.createElement("input");
                DiskonInput.className = "form-control";
                DiskonInput.name = "diskon[]";
                DiskonInput.type = "number";

                wrapperInputDiskon.appendChild(labelDiskonInput)
                wrapperInputDiskon.appendChild(DiskonInput)

                var removeBtn = document.createElement("button");
                removeBtn.type = "button"
                removeBtn.className = "remove-btn btn btn-sm btn-danger ml-2";
                removeBtn.textContent = "-";
                removeBtn.onclick = function() {
                    removeRow(this);
                };

                formRow.appendChild(labelTindakan)
                formRow.appendChild(selectTindakan)

                formRow2.appendChild(wrapperInputHarga)
                formRow2.appendChild(wrapperInputQuantity)
                formRow2.appendChild(wrapperInputDiskon)

                wrapperForm.appendChild(formRow)
                wrapperForm.appendChild(formRow2)

                wrapperFormMain.appendChild(wrapperForm)
                wrapperFormMain.appendChild(removeBtn)

                formContainer.appendChild(wrapperFormMain);
            }

            function removeRow(button) {
                var formRow = button.parentNode;
                formRow.parentNode.removeChild(formRow);
            }

            function assignValueTindakan(selectElement) {
                console.log(selectElement.value.split("-")[2]);
                var formRow = selectElement.parentNode.parentNode;
                var nameInput = formRow.querySelector('input[name="harga[]"]');
                nameInput.value = selectElement.value.split("-")[2];
            }

            function previewAction() {
                rowTindakan.innerHTML = ''
                var formRows = document.getElementsByClassName("form-row");
                var valuesArray = [];
                var dataJumlahKeseluruhan = []

                for (var i = 0; i < formRows.length; i++) {
                    var formRow = formRows[i];
                    var quantityInput = formRow.querySelector('input[name="quantity[]"]');
                    var diskonInput = formRow.querySelector('input[name="diskon[]"]');
                    var hargaInput = formRow.querySelector('input[name="harga[]"]');
                    var tindakanInput = formRow.querySelector('select[name="tindakan[]"]');

                    var valueObject = {
                        quantityInput: quantityInput.value,
                        diskonInput: diskonInput.value,
                        hargaInput: hargaInput.value,
                        tindakanInput: tindakanInput.value.split("-")[1],
                    };

                    const totalWithQty = parseInt(valueObject.quantityInput) * parseInt(valueObject.hargaInput)
                    const discountAmount = (totalWithQty * parseInt(valueObject.diskonInput)) / 100

                    const jumlahKalkulasi = valueObject.diskonInput ? totalWithQty - discountAmount : totalWithQty

                    rowTindakan.innerHTML += `
                        <tr>
                            <td>${i + 1}</td>
                            <td>${valueObject.tindakanInput}</td>
                            <td>${valueObject.quantityInput}</td>
                            <td>${valueObject.hargaInput}</td>
                            <td>${valueObject.diskonInput ? valueObject.diskonInput + "%" : ""}</td>
                            <td>
                                ${jumlahKalkulasi}
                            </td>
                        </tr>
                    `
                    dataJumlahKeseluruhan.push(jumlahKalkulasi)
                    valuesArray.push(valueObject);
                }


                var totalJumlahKalkulasi = dataJumlahKeseluruhan.reduce(function(accumulator, currentValue) {
                    return accumulator + currentValue;
                }, 0)
                totalJumlah.textContent = "Rp. " + totalJumlahKalkulasi
            }

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
                nomor_medis.value = nomorMedisValue ?? ""
                pasien_name.textContent = namaValue
                telp_pasien.textContent = teleponValue
                idPasien = idPasienValue
            }

            keterangan.addEventListener('input', function(evt) {
                keteranganDokter.textContent = keterangan.value
            })

            createTransaction.addEventListener('submit', function(e) {
                e.preventDefault();

                var formRows = document.getElementsByClassName("form-row");
                var valuesArray = [];

                for (var i = 0; i < formRows.length; i++) {
                    var formRow = formRows[i];
                    var quantityInput = formRow.querySelector('input[name="quantity[]"]');
                    var diskonInput = formRow.querySelector('input[name="diskon[]"]');
                    var hargaInput = formRow.querySelector('input[name="harga[]"]');
                    var tindakanInput = formRow.querySelector('select[name="tindakan[]"]');

                    var valueObject = {
                        quantityInput: quantityInput.value,
                        diskonInput: diskonInput.value,
                        hargaInput: hargaInput.value,
                        tindakanInput: tindakanInput.value.split("-")[0],
                    };

                    const totalWithQty = parseInt(valueObject.quantityInput) * parseInt(valueObject.hargaInput)
                    const discountAmount = (totalWithQty * parseInt(valueObject.diskonInput)) / 100

                    const jumlahKalkulasi = valueObject.diskonInput ? totalWithQty - discountAmount : totalWithQty

                    valueObject['subTotal'] = jumlahKalkulasi

                    valuesArray.push(valueObject);
                }

                let data = {
                    user_id: dokter_pilih.value,
                    patient_id: pasienChoose.value.split("-")[0],
                    keterangan: keterangan.value,
                    nomor_transaksi: noTrx.textContent,
                    tindakans: valuesArray,
                }

                // POST TRANSACTION
                fetch("{{ route('transaction.store') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        body: JSON.stringify(data)
                    })
                    .then(function(response) {
                        if (response.status === 201) {
                            console.log("Request successful. Status code:", response.status);
                            return response.json();
                        } else {
                            throw new Error("Request failed with status code: " + response.status);
                        }
                    })
                    .then(function(responseData) {
                        document.getElementById('showAlert').innerHTML += `
                            <div class="alert alert-success p-2 my-2" role="alert">
                                <span style="font-size: 16px;">Berhasil membuat tindakan!</span>
                            </div>
                        `
                        document.body.scrollTop = 0;
                        document.documentElement.scrollTop = 0;
                        // window.location.reload();
                    })
                    .catch(function(error) {
                        alert('Gagal membuat tindakan, coba lagi nanti!')
                        console.error("Error:", error);
                    });
            })

            // const downloadButton = document.getElementById('downloadButton');
            // downloadButton.addEventListener('click', () => {
            //     const content = document.getElementById('content');
            //     html2pdf()
            //         .set({
            //             margin: 10,
            //             filename: 'file.pdf',
            //             image: {
            //                 type: 'jpeg',
            //                 quality: 0.98
            //             },
            //             html2canvas: {
            //                 dpi: 192,
            //                 letterRendering: true
            //             },
            //             jsPDF: {
            //                 unit: 'mm',
            //                 format: 'a4',
            //                 orientation: 'portrait'
            //             },
            //         })
            //         .from(content)
            //         .save();
            // });

            // Update the JavaScript code to trigger the download
            const downloadButton = document.getElementById('downloadButton');
            downloadButton.addEventListener('click', () => {
                var valuesArray = [];
                var dataJumlahKeseluruhan = []
                var totalJumlahKalkulasi = 0
                var formRows = document.getElementsByClassName("form-row");

                for (var i = 0; i < formRows.length; i++) {
                    var formRow = formRows[i];
                    var quantityInput = formRow.querySelector('input[name="quantity[]"]');
                    var diskonInput = formRow.querySelector('input[name="diskon[]"]');
                    var hargaInput = formRow.querySelector('input[name="harga[]"]');
                    var tindakanInput = formRow.querySelector('select[name="tindakan[]"]');

                    var valueObject = {
                        quantity: quantityInput.value,
                        discount: diskonInput.value,
                        biaya: hargaInput.value,
                        nama_tindakan: tindakanInput.value.split("-")[1],
                    };

                    const totalWithQty = parseInt(valueObject.quantityInput) * parseInt(valueObject.hargaInput)
                    const discountAmount = (totalWithQty * parseInt(valueObject.diskonInput)) / 100

                    const jumlahKalkulasi = valueObject.diskonInput ? totalWithQty - discountAmount : totalWithQty

                    valueObject['subtotal'] = jumlahKalkulasi

                    dataJumlahKeseluruhan.push(jumlahKalkulasi)
                    valuesArray.push(valueObject);
                }

                totalJumlahKalkulasi = dataJumlahKeseluruhan.reduce(function(accumulator, currentValue) {
                    return accumulator + currentValue;
                }, 0)

                fetch(`
                /download-nota?tanggal={{ $dateNow }}
                &notrx=${noTrx.textContent}
                &nama_pasien=${pasienChoose.value.split("-")[1]}
                &keterangan=${keterangan.value}
                &notelp=${telp_pasien.textContent}
                &totally=${totalJumlahKalkulasi}
                `, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        body: JSON.stringify({
                            data_tindakan: valuesArray
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
            });
        </script>

    </div>
@endsection
