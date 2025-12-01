<?php
// report_penjualan_excel.php

require '../../vendor/autoload.php';
include '../../db/config_api.php';
include '../../db/api_client.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

// ========================
//   AMBIL DATA API
// ========================
$apiResponse = api_get('admin/report_penjualan.php?status=all');

$laporan = [];
$ringkasan = [
  'total_laporan' => 0,
  'total_pendapatan' => 0,
  'total_transaksi' => 0,
  'rata_rata_transaksi' => 0,
];

if ($apiResponse && isset($apiResponse['status']) && $apiResponse['status'] === true) {
  $data = $apiResponse['data'] ?? [];
  $laporan = $data['items'] ?? [];

  if (isset($data['ringkasan'])) {
    $ringkasan['total_laporan'] = $data['ringkasan']['total_laporan'] ?? 0;
    $ringkasan['total_pendapatan'] = $data['ringkasan']['total_pendapatan'] ?? 0;
    $ringkasan['total_transaksi'] = $data['ringkasan']['total_transaksi'] ?? 0;
    $ringkasan['rata_rata_transaksi'] = $data['ringkasan']['rata_rata_transaksi'] ?? 0;
  }
}

// ========================
//   BUAT EXCEL
// ========================
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// HEADER ATAS
$sheet->setCellValue('A1', 'LAPORAN PENJUALAN');
$sheet->setCellValue('A2', 'Export per: ' . date('d-m-Y H:i'));

$sheet->mergeCells('A1:E1');
$sheet->mergeCells('A2:E2');

$sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
$sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

// RINGKASAN
$summaryStartRow = 4;

$sheet->setCellValue("A{$summaryStartRow}", 'Total Laporan');
$sheet->setCellValue("B{$summaryStartRow}", (int) $ringkasan['total_laporan']);

$sheet->setCellValue("A" . ($summaryStartRow + 1), 'Total Transaksi');
$sheet->setCellValue("B" . ($summaryStartRow + 1), (int) $ringkasan['total_transaksi']);

$sheet->setCellValue("A" . ($summaryStartRow + 2), 'Total Pendapatan');
$sheet->setCellValue("B" . ($summaryStartRow + 2), (float) $ringkasan['total_pendapatan']);

$sheet->setCellValue("A" . ($summaryStartRow + 3), 'Rata-rata per Transaksi');
$sheet->setCellValue("B" . ($summaryStartRow + 3), (float) $ringkasan['rata_rata_transaksi']);

$sheet->getStyle("A{$summaryStartRow}:A" . ($summaryStartRow + 3))
  ->getFont()->setBold(true);

$sheet->getStyle("B" . ($summaryStartRow + 2) . ":B" . ($summaryStartRow + 3))
  ->getNumberFormat()->setFormatCode('"Rp" #,##0');

// HEADER TABEL
$headerRow = $summaryStartRow + 5;

$sheet->setCellValue("A{$headerRow}", 'No');
$sheet->setCellValue("B{$headerRow}", 'Nama Laporan');
$sheet->setCellValue("C{$headerRow}", 'Periode');
$sheet->setCellValue("D{$headerRow}", 'Total Transaksi');
$sheet->setCellValue("E{$headerRow}", 'Total Pendapatan');

$headerStyle = $sheet->getStyle("A{$headerRow}:E{$headerRow}");
$headerStyle->getFont()->setBold(true)->getColor()->setARGB('FFFFFFFF');
$headerStyle->getFill()->setFillType(Fill::FILL_SOLID)
  ->getStartColor()->setARGB('FF2563EB');
$headerStyle->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
$headerStyle->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

// DATA
$dataRowStart = $headerRow + 1;
$currentRow = $dataRowStart;
$no = 1;

if (!empty($laporan)) {
  foreach ($laporan as $item) {
    $sheet->setCellValue("A{$currentRow}", $no++);
    $sheet->setCellValue("B{$currentRow}", $item['nama_laporan'] ?? '');
    $sheet->setCellValue("C{$currentRow}", $item['periode'] ?? '');
    $sheet->setCellValue("D{$currentRow}", (int) ($item['total_transaksi'] ?? 0));
    $sheet->setCellValue("E{$currentRow}", (float) ($item['total_pendapatan'] ?? 0));

    $sheet->getStyle("A{$currentRow}:E{$currentRow}")
      ->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

    if ($currentRow % 2 == 0) {
      $sheet->getStyle("A{$currentRow}:E{$currentRow}")
        ->getFill()->setFillType(Fill::FILL_SOLID)
        ->getStartColor()->setARGB('FFF1F5F9');
    }

    $currentRow++;
  }
} else {
  $sheet->setCellValue("A{$currentRow}", 'Tidak ada data laporan penjualan');
  $sheet->mergeCells("A{$currentRow}:E{$currentRow}");
  $sheet->getStyle("A{$currentRow}:E{$currentRow}")
    ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
}

// FORMAT ANGKA
if ($currentRow > $dataRowStart) {
  $sheet->getStyle("D{$dataRowStart}:D" . ($currentRow - 1))
    ->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER);

  $sheet->getStyle("E{$dataRowStart}:E" . ($currentRow - 1))
    ->getNumberFormat()->setFormatCode('"Rp" #,##0');
}

// AUTO SIZE & FREEZE & FILTER
foreach (range('A', 'E') as $col) {
  $sheet->getColumnDimension($col)->setAutoSize(true);
}

$sheet->freezePane('A' . $dataRowStart);
$sheet->setAutoFilter("A{$headerRow}:E" . ($currentRow - 1));
$sheet->setTitle('Laporan Penjualan');

// OUTPUT
$filename = 'laporan_penjualan_' . date('Y-m-d_H-i') . '.xlsx';

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-Disposition: attachment; filename=\"{$filename}\"");
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
