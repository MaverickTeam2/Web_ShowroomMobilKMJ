<?php
require __DIR__ . '/vendor/autoload.php';

use Dompdf\Dompdf;

$pdf = new Dompdf();
$pdf->loadHtml("<h1>DOMPDF SUKSES! 🎉</h1>");
$pdf->render();
$pdf->stream("test.pdf", ["Attachment" => true]);
