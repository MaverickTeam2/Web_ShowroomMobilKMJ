<?php
// report_mobil_excel.php

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
$apiMobilResponse = api_get('admin/web_mobil_list.php');

$mobilList  = [];
$mobilStats = [
    'total_mobil'    => 0,
    'mobil_tersedia' => 0,
    'mobil_terjual'  => 0,
];

if ($apiMobilResponse && isset($apiMobilResponse['success']) && $apiMobilResponse['success'] === true) {
    $mobilList = $apiMobilResponse['data'] ?? [];

    foreach ($mobilList as $m) {
        $mobilStats['total_mobil']++;
        $status = strtolower(trim($m['status'] ?? ''));

        if ($status === 'available') $mobilStats['mobil_tersedia']++;
        if ($status === 'sold')      $mobilStats['mobil_terjual']++;
    }
}

// ========================
//   BUAT EXCEL
// ========================
$spreadsheet = new Spreadsheet();
$sheet       = $spreadsheet->getActiveSheet();

// HEADER ATAS
$sheet->setCellValue('A1', 'LAPORAN DATA MOBIL');
$sheet->setCellValue('A2', 'Export per: ' . date('d-m-Y H:i'));

$sheet->mergeCells('A1:F1');
$sheet->mergeCells('A2:F2');

$sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
$sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

// RINGKASAN
$summaryStart = 4;

$sheet->setCellValue("A{$summaryStart}",       'Total Mobil');
$sheet->setCellValue("B{$summaryStart}",       $mobilStats['total_mobil']);

$sheet->setCellValue("A".($summaryStart+1),    'Mobil Tersedia');
$sheet->setCellValue("B".($summaryStart+1),    $mobilStats['mobil_tersedia']);

$sheet->setCellValue("A".($summaryStart+2),    'Mobil Terjual');
$sheet->setCellValue("B".($summaryStart+2),    $mobilStats['mobil_terjual']);

$sheet->getStyle("A{$summaryStart}:A".($summaryStart+2))
      ->getFont()->setBold(true);

// HEADER TABEL
$headerRow = $summaryStart + 5;

$sheet->setCellValue("A{$headerRow}", 'No');
$sheet->setCellValue("B{$headerRow}", 'Nama Mobil');
$sheet->setCellValue("C{$headerRow}", 'Tahun');
$sheet->setCellValue("D{$headerRow}", 'Kode Mobil');
$sheet->setCellValue("E{$headerRow}", 'Status');
$sheet->setCellValue("F{$headerRow}", 'Harga');

// Style header
$headerStyle = $sheet->getStyle("A{$headerRow}:F{$headerRow}");
$headerStyle->getFont()->setBold(true)->getColor()->setARGB('FFFFFFFF');
$headerStyle->getFill()->setFillType(Fill::FILL_SOLID)
           ->getStartColor()->setARGB('FF16A34A'); // hijau
$headerStyle->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
$headerStyle->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

// DATA
$dataRowStart = $headerRow + 1;
$row          = $dataRowStart;
$no           = 1;

if (!empty($mobilList)) {
    foreach ($mobilList as $m) {
        $sheet->setCellValue("A{$row}", $no++);
        $sheet->setCellValue("B{$row}", $m['nama_mobil'] ?? '');
        $sheet->setCellValue("C{$row}", $m['tahun_mobil'] ?? '');
        $sheet->setCellValue("D{$row}", $m['kode_mobil'] ?? '');
        $sheet->setCellValue("E{$row}", $m['status'] ?? '');
        $sheet->setCellValue("F{$row}", (float)($m['full_prize'] ?? 0));

        $sheet->getStyle("A{$row}:F{$row}")
              ->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        if ($row % 2 == 0) {
            $sheet->getStyle("A{$row}:F{$row}")
                  ->getFill()->setFillType(Fill::FILL_SOLID)
                  ->getStartColor()->setARGB('FFDFFBE6');
        }

        $sheet->getStyle("F{$row}")
              ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

        $row++;
    }
} else {
    $sheet->setCellValue("A{$row}", 'Belum ada data mobil');
    $sheet->mergeCells("A{$row}:F{$row}");
    $sheet->getStyle("A{$row}:F{$row}")
          ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
}

// FORMAT HARGA
if ($row > $dataRowStart) {
    $sheet->getStyle("F{$dataRowStart}:F".($row-1))
          ->getNumberFormat()->setFormatCode('"Rp" #,##0');
}

// AUTO SIZE, FREEZE, FILTER
foreach (range('A', 'F') as $col) {
    $sheet->getColumnDimension($col)->setAutoSize(true);
}

$sheet->freezePane('A'.$dataRowStart);
$sheet->setAutoFilter("A{$headerRow}:F".($row-1));
$sheet->setTitle('Data Mobil');

// OUTPUT
$filename = 'laporan_mobil_' . date('Y-m-d_H-i') . '.xlsx';

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-Disposition: attachment; filename=\"{$filename}\"");
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
