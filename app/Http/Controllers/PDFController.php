<?php

namespace App\Http\Controllers;

use App\Models\Transactions;
use App\Models\User;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Dompdf\Options;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class PDFController extends Controller
{
    public function downloadPDF(Request $request)
    {
        $tindakan = '';
        $html = '
        <style>
            * {
                font-family: Arial, Helvetica, sans-serif;
            }

            .tabelTindakan tr th {
                border-bottom: 2px solid black;
            }

            .wrapperMain {
                width: 100%;
            }

            .fs10px {
                font-size: 11px;
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
            <p class="textRight fs10px">Bandung ' . $request->query('tanggal') . '</p>

            <table style="width: 100%; padding: 0px;">
                <tr>
                    <td style="text-align: left;">
                        <p class="fs10px" style="font-weight: bold; ">RINCIAN RAWAT JALAN PASIEN</p>
                    </td>
                    <td style="text-align: right;">
                        <p class="fs10px" style="">No. ' . $request->query('notrx') . '</p>
                    </td>
                </tr>
            </table>

            <table style="width: 100%; padding: 0px;">
                <tr>
                    <td style="text-align: left;">
                        <p class="fs10px" style="">PRAKTEK DOKTER GIGI SPESIALISTIK</p>
                    </td>
                    <td style="text-align: right;">
                        <p class="fs10px" style="">Nama Pasien: ' . $request->query('nama_pasien') . '</p>
                    </td>
                </tr>
            </table>

            <table style="width: 100%; padding: 0px;">
                <tr>
                    <td style="text-align: left;">
                        <p class="fs10px" style="">Jl. Tanjung Sari No.32, Antapani. Bandung 08112276161</p>
                    </td>
                    <td style="text-align: right;">
                        <p class="fs10px" style="">No telp Pasien: ' . $request->query('notelp') . '</p>
                    </td>
                </tr>
            </table>

            <table style="width: 100%; padding: 0px;" cellspacing="5" class="tabelTindakan">
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
                <?php foreach ($request->data_tindakan as $key => $value): ?>
                    <tr>
                        <td><?php echo $key + 1; ?></td>
                        <td><?php echo $value["nama_tindakan"] ?></td>
                        <td><?php echo $value["quantity"] ?></td>
                        <td><?php echo $value["biaya"] ?></td>
                        <td><?php echo $value["discount"] ?></td>
                        <td><?php echo $value["subtotal"] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    

            <p style="font-size: 13px; text-align: right;">Total: Rp. ' . number_format(intval($request->query('totally')), 0, ',', '.') . '</p>

            <p style="font-size: 13px; text-align: left;">Keterangan Dokter: </p>
            <p style="
                font-size: 13px; 
                text-align: left; 
                word-wrap: break-word;
                white-space: -moz-pre-wrap;
                white-space: pre-wrap;
                "> ' . $request->query('keterangan') . ' </p>

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
        
        
        ';

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);

        $options = new Options();
        $options->setIsPhpEnabled(true); // Enable PHP evaluation in the HTML content
        $dompdf->setOptions($options);

        $dompdf->setPaper('A5', 'portrait');
        $dompdf->render();

        $output = $dompdf->output();

        return new Response($output, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="file.pdf"',
        ]);
    }

    public function downloadExcel(Request $request)
    {
        $dataKinerja = Transactions::with('dokter', 'pasien', 'transaction_tindak', 'transaction_tindak.tindakan')->where('user_id', '=', $request->query('dokter_id'))->whereBetween('created_at', [date($request->query('startDate')), date($request->query('endDate'))])->get(); // Replace with your logic to fetch the data

        // Create a new Spreadsheet object
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set table headers
        $headers = [
            'Tanggal',
            'Nomor Transaksi',
            'Nama Pasien',
            'Jenis Tindakan',
            'Jumlah',
            'Harga',
            'Diskon',
            'Subtotal',
            'Jasa Medis',
        ];

        $sheet->fromArray($headers, null, 'A1');

        // Set data rows
        $row = 2;
        foreach ($dataKinerja as $transaction) {
            $sheet->setCellValue('A' . $row, $transaction->created_at->format('d-F-Y'));
            $sheet->setCellValue('B' . $row, $transaction->nomor_transaksi);
            $sheet->setCellValue('C' . $row, $transaction->pasien->nama_pasien);

            $subRow = $row;
            foreach ($transaction->transaction_tindak as $tindakan) {
                $sheet->setCellValue('D' . $subRow, $tindakan->tindakan->nama_tindakan);
                $sheet->setCellValue('E' . $subRow, $tindakan->quantity);
                $sheet->setCellValue('F' . $subRow, $tindakan->biaya);
                $sheet->setCellValue('G' . $subRow, $tindakan->discount);
                $sheet->setCellValue('H' . $subRow, $tindakan->subtotal);
                $sheet->setCellValue('I' . $subRow, $tindakan->tindakan->jasa_medis);

                $subRow++;
            }

            $row = $subRow;
        }

        // Set total row
        $totalRow = $row;
        $sheet->mergeCells('A' . $totalRow . ':G' . $totalRow);
        $sheet->setCellValue('A' . $totalRow, 'Total');
        $sheet->mergeCells('H' . $totalRow . ':I' . $totalRow);
        $sheet->setCellValue('H' . $totalRow, 'Rp. ' . number_format($request->query('total'), 0, ',', '.'));

        // Auto-size columns
        foreach (range('A', 'I') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        // Create a temporary file to save the spreadsheet
        $tempFile = tempnam(sys_get_temp_dir(), 'excel');

        // Save the spreadsheet to the temporary file
        $writer = new Xlsx($spreadsheet);
        $writer->save($tempFile);

        $userDokter = User::find($request->query('dokter_id'));

        // Set the response headers for file download
        $response = new BinaryFileResponse($tempFile);
        $response->setContentDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            'Kinerja_ ' . $userDokter->nama . '_' . Carbon::parse($request->query('startDate'))->format('d-F-Y') . '-' . Carbon::parse($request->query('endDate'))->format('d-F-Y') . '.xlsx'
        );

        // Delete the temporary file after the response is sent
        $response->deleteFileAfterSend(true);

        return $response;
    }
}
