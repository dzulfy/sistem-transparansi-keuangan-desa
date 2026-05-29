<?php

require_once '../config/database.php';
require_once '../vendor/autoload.php';

use Dompdf\Dompdf;

$id = $_GET['id'] ?? 0;

$stmt = $pdo->prepare("
    SELECT * FROM laporan 
    WHERE id_laporan = ?
");

$stmt->execute([$id]);

$data = $stmt->fetch();

if (!$data) {
    die("Data tidak ditemukan");
}

$html = "
<h2>Laporan Keuangan Desa</h2>

<hr>

<p><strong>Periode:</strong> {$data['periode']}</p>

<p><strong>Total Anggaran:</strong> Rp " . number_format($data['total_anggaran'], 0, ',', '.') . "</p>

<p><strong>Total Realisasi:</strong> Rp " . number_format($data['total_realisasi'], 0, ',', '.') . "</p>

<p><strong>Status:</strong> {$data['status']}</p>
";

$dompdf = new Dompdf();

$dompdf->loadHtml($html);

$dompdf->setPaper('A4', 'portrait');

$dompdf->render();

$dompdf->stream("laporan.pdf", [
    "Attachment" => false
]);