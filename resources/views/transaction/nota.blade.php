<style>
    * {
        font-family: Arial, Helvetica, sans-serif;
    }

    .tabelTindakan thead tr th {
        border-bottom: 2px solid black;
    }

    .wrapperMain {
        width: 100%;
    }

    .fs10px {
        font-size: 11px;
    }

    .fs12px {
        font-size: 12.5px;
    }

    .text-center {
        text-align: center;
    }

    .textRight {
        text-align: right;
    }

    .dFlexBetween {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
</style>

<div class="wrapperMain">
    <p class="textRight fs10px">Bandung {{ $data['tanggal'] }}</p>

    <table style="width: 100%; padding: 0px;">
        <tr>
            <td style="text-align: left;">
                <p class="fs10px" style="font-weight: bold; ">RINCIAN RAWAT JALAN PASIEN</p>
            </td>
            <td style="text-align: right;">
                <p class="fs10px" style="">No. {{ $data['notrx'] }}</p>
            </td>
        </tr>
    </table>

    <table style="width: 100%; padding: 0px;">
        <tr>
            <td style="text-align: left;">
                <p class="fs10px" style="">PRAKTEK DOKTER GIGI SPESIALISTIK</p>
            </td>
            <td style="text-align: right;">
                <p class="fs10px" style="">Nama Pasien: {{ $data['nama_pasien'] }}</p>
            </td>
        </tr>
    </table>

    <table style="width: 100%; padding: 0px;">
        <tr>
            <td style="text-align: left;">
                <p class="fs10px" style="">Jl. Tanjung Sari No.32, Antapani. Bandung 08112276161</p>
            </td>
            <td style="text-align: right;">
                <p class="fs10px" style="">No telp Pasien: {{ $data['notelp'] }}</p>
            </td>
        </tr>
    </table>

    <table style="width: 100%; padding: 0px;" cellspacing="5" class="tabelTindakan">
        <thead>
            <tr>
                <th class="fs12px">No</th>
                <th class="fs12px">Nama Tindakan</th>
                <th class="fs12px">Qty</th>
                <th class="fs12px">Harga</th>
                <th class="fs12px">Diskon%</th>
                <th class="fs12px">Jumlah</th>
            </tr>
        </thead>
        <tbody id="rowTindakan">
            <?php foreach ($data["tindakans"] as $key => $value): ?>
            <tr>
                <td class="fs12px text-center"><?php echo $key + 1; ?></td>
                <td class="fs12px text-center"><?php echo $value['nama_tindakan']; ?></td>
                <td class="fs12px text-center"><?php echo $value['quantity']; ?></td>
                <td class="fs12px text-center"><?php echo number_format(intval($value['biaya']), 0, ',', '.'); ?></td>
                <td class="fs12px text-center"><?php echo $value['discount']; ?></td>
                <td class="fs12px text-center"><?php echo number_format($value['subtotal'], 0, ',', '.'); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>


    <p style="font-size: 13px; text-align: right;">Total: Rp. {{ number_format(intval($data['totally']), 0, ',', '.') }}</p>

    <p style="font-size: 13px; text-align: left;">Keterangan Dokter: </p>
    <p style="
        font-size: 13px; 
        text-align: left; 
        word-wrap: break-word;
        white-space: -moz-pre-wrap;
        white-space: pre-wrap;
        ">
        {{ $data['keterangan'] }} </p>

    <table style="width: 100%; padding: 0px;">
        <tr>
            <td style="text-align: left;">
                <p class="fs10px" style="">Perhatian</p>
            </td>
            <td style="text-align: right;">
                <p class="fs10px" style="">Hormat Kami, </p>
            </td>
        </tr>
    </table>

    <table style="width: 100%; padding: 0px; margin-top: 10px;">
        <tr>
            <td style="text-align: left;">
                <p class="fs10px" style="">Kuitansi ini merupakan bukti pembayaran</p>
            </td>
            <td style="text-align: right;">
                <p class="fs10px" style="">(.........................)</p>
            </td>
        </tr>
    </table>


</div>
