<style>
    @media print {
        @page {
            size: 8.5in 11in;
        }
    }

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
                                        <input type="number" id="hargaFirst" readonly name="harga[]" class="form-control form-input">
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
            <div class="card rounded-2 ">
                <div class="card-body struk" id="struk">
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
                <center>
                    <button id="printPdf" class="btn btn-lg btn-info my-3" onclick="printDiv('struk')">Download PDF</button>
                </center>
            </div>


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
            const tindakanShow = document.getElementById('tindakanList')
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
                hargaInput.readOnly = true;

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
                        tindakanInput: tindakanInput.value.split("-")[1],
                    };

                    valuesArray.push(valueObject);
                }

                console.log(valuesArray);
            }

            // let tindakanList = []

            // tindakanList.push({
            //     id: Math.floor(10000 + Math.random() * 90000),
            //     tindakan: "",
            //     quantity: "",
            //     diskon: "",
            // })

            // function tambahTindak() {
            //     console.log("TEST");
            //     tindakanList.push({
            //         id: Math.floor(10000 + Math.random() * 90000),
            //         tindakan: "",
            //         quantity: "",
            //         diskon: "",
            //     })
            //     renderTindakan()
            // }

            // function renderTindakan() {

            //     // Store the selected option value
            //     const selectedOptions = Array.from(tindakanShow.querySelectorAll('form-select')).map(select => select.value);

            //     // Store the input values
            //     const tindakanInputs = Array.from(tindakanShow.querySelectorAll('.form-input'));

            //     tindakanShow.innerHTML = ''
            //     tindakanList.map(tindakan => {
            //         tindakanShow.innerHTML += `
    //     <div class="form-group mb-3">
    //                 <label for="">Tindakan</label>
    //                 <select name="tindakan" onchange="console.log(this.value)" id="tindakan" class="form-control form-select">
    //                     <option value="">Pilih Tindakan</option>
    //                     @foreach ($data_tindakan as $item)
    //                         <option value="{{ $item->id }}-{{ $item->nama_tindakan }}-{{ $item->total_harga }}">{{ $item->nama_tindakan }}</option>
    //                     @endforeach
    //                 </select>
    //             </div>
    //             <div class="d-flex mb-3">
    //                 <div class="mr-2">
    //                     <label for="">Harga</label>
    //                     <input type="number" oninput="console.log(this.value)" name="harga" class="form-control form-input">
    //                 </div>
    //                 <div class="mr-2">
    //                     <label for="">Quantity</label>
    //                     <input type="number" name="quantity" class="form-control form-input">
    //                 </div>
    //                 <div class="mr-2">
    //                     <label for="">Diskon (%)</label>
    //                     <input type="number" name="diskon" class="form-control form-input">
    //                 </div>
    //                 <div class="mr-2">
    //                     <button type="button" class="btn btn-sm btn-danger" onclick="${() => {
    //                             console.log("ID: " + tindakan.id);
    //                         tindakanList.filter(tindak => tindak.id !== tindakan.id );
    //                         renderTindakan(); }
    //                     }">-</button>
    //                 </div>
    //             </div>
    //     `
            //     })

            //     // Set the selected option value
            //     const selectElements = tindakanShow.querySelectorAll('form-select');
            //     selectedOptions.forEach((optionValue, index) => {
            //         if (index < selectElements.length) {
            //             selectElements[index].value = optionValue;
            //         }
            //     });

            //     // Set the input values
            //     tindakanInputs.forEach((input, index) => {
            //         if (index < tindakanList.length) {
            //             input.value = tindakanList[index].tindakan;
            //             // Set other input values as needed
            //         }
            //     });
            // }

            // renderTindakan()

            noTrx.textContent = `DC-${Math.floor(1000000 + Math.random() * 9000000)}`

            // function printDiv(className) {
            //     // Get the div element with the specified class
            //     const divToPrint = document.querySelector(`.${className}`);

            //     // Check if the div exists
            //     if (divToPrint) {
            //         // Clone the div element and its contents
            //         const clonedDiv = divToPrint.cloneNode(true);

            //         // Create a new window to print the document
            //         const printWindow = window.open('', '_blank');

            //         // Specify the A5 dimensions in millimeters (148mm x 210mm)
            //         const paperWidth = 148;
            //         const paperHeight = 210;

            //         // Set the print window's content to the cloned div
            //         printWindow.document.write('<html><head><title>A5 Document</title></head><body></body></html>');
            //         printWindow.document.getElementsByTagName('body')[0].appendChild(clonedDiv);
            //         printWindow.document.close();

            //         // Wait for the cloned div to finish loading
            //         clonedDiv.onload = function() {
            //             // Set the print window's paper size and dimensions
            //             printWindow.document.getElementsByTagName('body')[0].style.width = `${paperWidth}mm`;
            //             printWindow.document.getElementsByTagName('body')[0].style.height = `${paperHeight}mm`;

            //             // Wait for the document to load in the print window
            //             printWindow.addEventListener('load', function() {
            //                 // Print the document
            //                 printWindow.print();
            //                 // Close the print window after printing
            //                 printWindow.close();
            //             });
            //         };
            //     } else {
            //         console.log(`No element found with class '${className}'.`);
            //     }

            // }


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
                console.log(this.value);
                keteranganDokter.textContent = keterangan.value
            })
        </script>

    </div>
@endsection
