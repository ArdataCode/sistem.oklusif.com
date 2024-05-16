<?php

namespace App\Http\Controllers;

use App\Models\Transactions;
use App\Models\User;
use Carbon\Carbon;
use App\Models\Pasiens;
use PDF;
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
    public function generateNota(Request $request)
    {
        $pdf = PDF::loadView('transaction.nota', ['data' => [
            "tanggal" => $request->query('tanggal'),
            "notrx" => $request->query('notrx'),
            "nama_pasien" => $request->query('nama_pasien'),
            "notelp" => $request->query('notelp'),
            "totally" => intval($request->query('totally')),
            "keterangan" => $request->query('keterangan'),
            "tindakans" => $request->data_tindakan
        ]])->setPaper('a5', 'landscape');

        $pdf->setOptions([
            'isRemoteEnabled' => true,
            'isHtml5ParserEnabled' => true,
        ]);

        $pdfContent = $pdf->output();
        $headers = [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="file.pdf"',
        ];

        return new Response($pdfContent, 200, $headers);
    }

    public function generatePasien(Request $request)
    {
        $id_pasien = $request->query('id');

        $data_patient = Pasiens::with('transactions', 'transactions.transaction_tindak', 'transactions.dokter', 'transactions.transaction_tindak.tindakan')->where('id', '=', $id_pasien)->first();

        $pdf = PDF::loadView('pasien.pasien_pdf', ['data_patient' => $data_patient]);

        $pdf->setOptions([
            'isRemoteEnabled' => true,
            'isHtml5ParserEnabled' => true,
        ]);

        $pdfContent = $pdf->output();
        $headers = [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="file.pdf"',
        ];

        return new Response($pdfContent, 200, $headers);
    }

    public function downloadExcel(Request $request)
    {
        $startDate = date('Y-m-d', strtotime($request->query('startDate')));
        $endDate = date('Y-m-d', strtotime($request->query('endDate')));
        $dataKinerja = Transactions::with('dokter', 'pasien', 'transaction_tindak', 'transaction_tindak.tindakan')->where('user_id', '=', $request->query('dokter_id'))->whereBetween('created_at', [date('Y-m-d', strtotime($startDate . ' -1 day')), date('Y-m-d', strtotime($endDate . ' +1 day'))])->get(); // Replace with your logic to fetch the data

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
            'Biaya Lain',
            'Keterangan',
        ];

        $sheet->fromArray($headers, null, 'A1');

        // Set data rows
        $row = 2;
        foreach ($dataKinerja as $transaction) {
            $sheet->setCellValue('A' . $row, $transaction->created_at->format('d-F-Y'));
            $sheet->setCellValue('B' . $row, $transaction->nomor_transaksi);
            $sheet->setCellValue('C' . $row, $transaction->pasien->nama_pasien ?? "");

            $subRow = $row;
            foreach ($transaction->transaction_tindak as $tindakan) {
                $sheet->setCellValue('D' . $subRow, $tindakan->tindakan->nama_tindakan ?? "");
                $sheet->setCellValue('E' . $subRow, $tindakan->quantity);
                $sheet->setCellValue('F' . $subRow, $tindakan->biaya);
                $sheet->setCellValue('G' . $subRow, $tindakan->discount);
                $sheet->setCellValue('H' . $subRow, $tindakan->subtotal);
                $sheet->setCellValue('I' . $subRow, $tindakan->quantity * $tindakan->tindakan->jasa_medis ?? "");
                $sheet->setCellValue('J' . $subRow, $tindakan->biayalain);
                $sheet->setCellValue('K' . $subRow, $tindakan->keteranganlain);

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
