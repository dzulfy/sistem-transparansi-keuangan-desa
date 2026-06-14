<?php

require_once 'config/database.php';
require_once 'vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

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

// Hitung persentase realisasi
$persentase = 0;
if ($data['total_anggaran'] > 0) {
    $persentase = ($data['total_realisasi'] / $data['total_anggaran']) * 100;
}

$html = '
<!DOCTYPE html>
<html>`
<head>
    <meta charset="UTF-8">
    <style>

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #333;
        }

        .header {
            text-align: center;
            border-bottom: 3px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .header h2 {
            margin: 0;
        }

        .header p {
            margin: 2px 0;
        }

        .title {
            text-align: center;
            margin-bottom: 20px;
        }

        .title h3 {
            margin: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        .table-data td {
            border: 1px solid #000;
            padding: 10px;
        }

        .table-data th {
            background: #eaeaea;
            border: 1px solid #000;
            padding: 10px;
        }

        .footer {
            margin-top: 50px;
        }

        .signature {
            width: 250px;
            float: right;
            text-align: center;
        }

        .status {
            font-weight: bold;
        }

        .success {
            color: green;
        }

        .warning {
            color: orange;
        }

        .print-date {
            margin-top: 20px;
            font-size: 10px;
            text-align: right;
        }

    </style>
</head>
<body>

    <div class="header">
        <h2>PEMERINTAH KABUPATEN KARAWANG</h2>
        <h2>KECAMATAN TELUKJAMBE TIMUR</h2>
        <h2>DESA PURWADANA</h2>
        <p>Alamat: Jl. Bobojong No. 1 Desa Purwadana</p>
    </div>

    <div class="title">
        <h3>LAPORAN KEUANGAN DESA</h3>
        <p>Periode: '.$data['periode'].'</p>
    </div>

    <table class="table-data">
        <tr>
            <th width="40%">Keterangan</th>
            <th>Nilai</th>
        </tr>

        <tr>
            <td>Total Anggaran</td>
            <td>Rp '.number_format($data['total_anggaran'],0,",",".").'</td>
        </tr>

        <tr>
            <td>Total Realisasi</td>
            <td>Rp '.number_format($data['total_realisasi'],0,",",".").'</td>
        </tr>

        <tr>
            <td>Sisa Anggaran</td>
            <td>Rp '.number_format(
                $data['total_anggaran'] - $data['total_realisasi'],
                0,",","."
            ).'</td>
        </tr>

        <tr>
            <td>Persentase Realisasi</td>
            <td>'.number_format($persentase,2).'%</td>
        </tr>

        <tr>
            <td>Status Laporan</td>
            <td class="status">'.$data['status'].'</td>
        </tr>
    </table>

    <div class="print-date">
        Dicetak pada: '.date('d F Y H:i:s').'
    </div>

    <div class="footer">
        <div class="signature">
            <p>Mengetahui,</p>
            <p>Kepala Desa</p>

            <br><br><br>

            <p><strong>__________________</strong></p>
        </div>
    </div>

</body>
</html>
';

$options = new Options();
$options->set('isRemoteEnabled', true);

$dompdf = new Dompdf($options);

$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

$dompdf->stream("laporan_keuangan_desa.pdf", [
    "Attachment" => false
]);