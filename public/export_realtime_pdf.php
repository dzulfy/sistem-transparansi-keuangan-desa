<?php
require_once '../config/database.php';
require_once '../vendor/autoload.php';

use Dompdf\Dompdf;

// 1. Fetch totals
$stmt = $pdo->query("SELECT SUM(jumlah_anggaran) as total FROM anggaran WHERE status = 'APPROVED'");
$totalAnggaran = $stmt->fetch()['total'] ?? 0;

$stmt = $pdo->query("SELECT SUM(jumlah_realisasi) as total FROM realisasi WHERE status = 'APPROVED'");
$totalRealisasi = $stmt->fetch()['total'] ?? 0;

$sisaAnggaran = $totalAnggaran - $totalRealisasi;

// 2. Fetch details
$stmt = $pdo->query("
    SELECT a.nama_kegiatan, a.jumlah_anggaran, COALESCE(SUM(r.jumlah_realisasi), 0) as total_realisasi 
    FROM anggaran a 
    LEFT JOIN realisasi r ON a.id_anggaran = r.id_anggaran AND r.status = 'APPROVED' 
    WHERE a.status = 'APPROVED' 
    GROUP BY a.id_anggaran, a.nama_kegiatan, a.jumlah_anggaran 
    ORDER BY a.id_anggaran DESC
");
$budgets = $stmt->fetchAll();

// 3. Generate HTML with inline styles compatible with Dompdf
$html = '
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<style>
    body { font-family: sans-serif; color: #333; padding: 15px; }
    h2 { text-align: center; margin-bottom: 2px; color: #0f172a; }
    h4 { text-align: center; color: #64748b; margin-top: 2px; margin-bottom: 20px; font-weight: normal; font-size: 12px; }
    
    .table-summary { width: 100%; border-collapse: collapse; margin-bottom: 25px; }
    .table-summary th, .table-summary td { border: 1px solid #cbd5e1; padding: 10px; text-align: left; font-size: 13px; }
    .table-summary th { background-color: #f8fafc; color: #334155; width: 40%; }
    .table-summary td { font-weight: bold; }
    
    .table-detail { width: 100%; border-collapse: collapse; margin-top: 10px; }
    .table-detail th, .table-detail td { border: 1px solid #cbd5e1; padding: 8px; text-align: left; font-size: 11px; }
    .table-detail th { background-color: #1e3a5f; color: white; text-transform: uppercase; font-size: 10px; letter-spacing: 0.5px; }
    .text-right { text-align: right; }
    .text-center { text-align: center; }
    .font-semibold { font-weight: bold; }
</style>
</head>
<body>

<h2>LAPORAN REALISASI ANGGARAN REAL-TIME</h2>
<h4>Sistem Transparansi Keuangan Desa Maju Jaya - Tanggal Cetak: ' . date('d M Y') . '</h4>

<table class="table-summary">
    <tr>
        <th>Total Anggaran Disetujui</th>
        <td>Rp ' . number_format($totalAnggaran, 0, ',', '.') . '</td>
    </tr>
    <tr>
        <th>Total Realisasi Belanja</th>
        <td style="color: #16a34a;">Rp ' . number_format($totalRealisasi, 0, ',', '.') . '</td>
    </tr>
    <tr>
        <th>Sisa Saldo Anggaran</th>
        <td style="color: #2563eb;">Rp ' . number_format($sisaAnggaran, 0, ',', '.') . '</td>
    </tr>
</table>

<h3 style="color: #0f172a; font-size: 14px; margin-top: 20px; border-bottom: 2px solid #cbd5e1; padding-bottom: 5px;">Rincian Penyerapan Per Kegiatan</h3>
<table class="table-detail">
    <thead>
        <tr>
            <th>Nama Kegiatan</th>
            <th class="text-right" style="width: 20%;">Pagu Anggaran</th>
            <th class="text-right" style="width: 20%;">Total Realisasi</th>
            <th class="text-right" style="width: 20%;">Sisa Dana</th>
            <th class="text-center" style="width: 12%;">Penyerapan</th>
        </tr>
    </thead>
    <tbody>
';

if (count($budgets) > 0) {
    foreach ($budgets as $row) {
        $sisa = $row['jumlah_anggaran'] - $row['total_realisasi'];
        $persen = $row['jumlah_anggaran'] > 0 ? ($row['total_realisasi'] / $row['jumlah_anggaran']) * 100 : 0;
        $html .= '
        <tr>
            <td class="font-semibold">' . htmlspecialchars($row['nama_kegiatan']) . '</td>
            <td class="text-right">Rp ' . number_format($row['jumlah_anggaran'], 0, ',', '.') . '</td>
            <td class="text-right" style="color: #16a34a;">Rp ' . number_format($row['total_realisasi'], 0, ',', '.') . '</td>
            <td class="text-right ' . ($sisa < 0 ? 'color: red;' : '') . '">Rp ' . number_format($sisa, 0, ',', '.') . '</td>
            <td class="text-center font-semibold">' . number_format($persen, 1) . '%</td>
        </tr>';
    }
} else {
    $html .= '<tr><td colspan="5" class="text-center" style="padding: 20px; color: #64748b;">Belum ada anggaran disetujui (APPROVED).</td></tr>';
}

$html .= '
    </tbody>
</table>

<div style="margin-top: 50px; text-align: right; font-size: 11px; color: #64748b;">
    <p>Dokumen ini dihasilkan secara otomatis oleh Sistem Transparansi Keuangan Desa Maju Jaya</p>
    <p>Sebagai wujud transparansi publik yang akuntabel dan terpercaya.</p>
</div>

</body>
</html>
';

$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

$dompdf->stream("laporan-realtime.pdf", [
    "Attachment" => false
]);
