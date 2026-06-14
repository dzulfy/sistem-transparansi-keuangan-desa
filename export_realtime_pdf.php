<?php

require_once 'config/database.php';
require_once 'vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

// =========================================
// Ambil Data Ringkasan
// =========================================

// Total Anggaran
$stmt = $pdo->query("
    SELECT SUM(jumlah_anggaran) as total
    FROM anggaran
    WHERE status = 'APPROVED'
");
$totalAnggaran = $stmt->fetch()['total'] ?? 0;

// Total Realisasi
$stmt = $pdo->query("
    SELECT SUM(jumlah_realisasi) as total
    FROM realisasi
    WHERE status = 'APPROVED'
");
$totalRealisasi = $stmt->fetch()['total'] ?? 0;

$sisaAnggaran = $totalAnggaran - $totalRealisasi;

// =========================================
// Ambil Data Detail Kegiatan
// =========================================

$stmt = $pdo->query("
    SELECT
        a.id_anggaran,
        a.nama_kegiatan,
        a.jumlah_anggaran,
        COALESCE(SUM(r.jumlah_realisasi),0) AS total_realisasi
    FROM anggaran a
    LEFT JOIN realisasi r
        ON a.id_anggaran = r.id_anggaran
        AND r.status = 'APPROVED'
    WHERE a.status = 'APPROVED'
    GROUP BY
        a.id_anggaran,
        a.nama_kegiatan,
        a.jumlah_anggaran
    ORDER BY a.id_anggaran DESC
");

$budgets = $stmt->fetchAll();

// =========================================
// HTML PDF
// =========================================

$html = '
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">

<style>

body{
    font-family: DejaVu Sans, sans-serif;
    font-size: 11px;
    color: #000;
    margin: 20px;
}

.header{
    text-align:center;
    border-bottom:3px solid #000;
    padding-bottom:10px;
    margin-bottom:20px;
}

.header h2,
.header h3,
.header p{
    margin:2px;
}

.title{
    text-align:center;
    margin-top:15px;
    margin-bottom:15px;
}

.info{
    margin-bottom:15px;
}

.summary-table{
    width:100%;
    border-collapse:collapse;
    margin-bottom:20px;
}

.summary-table th,
.summary-table td{
    border:1px solid #000;
    padding:8px;
}

.summary-table th{
    width:40%;
    background:#f2f2f2;
    text-align:left;
}

.detail-table{
    width:100%;
    border-collapse:collapse;
}

.detail-table th,
.detail-table td{
    border:1px solid #000;
    padding:8px;
}

.detail-table th{
    background:#e5e5e5;
    text-align:center;
    font-weight:bold;
}

.text-right{
    text-align:right;
}

.text-center{
    text-align:center;
}

.footer{
    margin-top:60px;
}

.signature{
    width:250px;
    float:right;
    text-align:center;
}

.note{
    margin-top:80px;
    text-align:center;
    font-size:10px;
}

</style>

</head>

<body>

<div class="header">
    <h2>PEMERINTAH DESA PURWADANA</h2>
    <h3>LAPORAN REALISASI ANGGARAN DESA</h3>
    <p>Kecamatan Telukjambe Timur, Kabupaten Karawang</p>
</div>

<table width="100%" style="margin-bottom:15px;">
    <tr>
        <td>
            <strong>Tanggal Cetak :</strong> '.date('d F Y H:i:s').'
        </td>

        <td align="right">
            <strong>Tahun :</strong> '.date('Y').'
        </td>
    </tr>
</table>

<table class="summary-table">
    <tr>
        <th>Total Anggaran Disetujui</th>
        <td>
            Rp '.number_format($totalAnggaran,0,",",".").'
        </td>
    </tr>

    <tr>
        <th>Total Realisasi</th>
        <td>
            Rp '.number_format($totalRealisasi,0,",",".").'
        </td>
    </tr>

    <tr>
        <th>Sisa Anggaran</th>
        <td>
            Rp '.number_format($sisaAnggaran,0,",",".").'
        </td>
    </tr>
</table>

<div class="title">
    <h3>RINCIAN PENYERAPAN ANGGARAN PER KEGIATAN</h3>
</div>

<table class="detail-table">
    <thead>
        <tr>
            <th width="5%">No</th>
            <th width="35%">Nama Kegiatan</th>
            <th width="20%">Pagu Anggaran</th>
            <th width="20%">Realisasi</th>
            <th width="10%">Sisa</th>
            <th width="10%">%</th>
        </tr>
    </thead>

    <tbody>
';

if(count($budgets) > 0){

    $no = 1;

    foreach($budgets as $row){

        $sisa = $row['jumlah_anggaran'] - $row['total_realisasi'];

        $persen = 0;

        if($row['jumlah_anggaran'] > 0){
            $persen = (
                $row['total_realisasi']
                /
                $row['jumlah_anggaran']
            ) * 100;
        }

        $html .= '
        <tr>

            <td class="text-center">
                '.$no++.'
            </td>

            <td>
                '.htmlspecialchars($row['nama_kegiatan']).'
            </td>

            <td class="text-right">
                Rp '.number_format(
                    $row['jumlah_anggaran'],
                    0,
                    ",",
                    "."
                ).'
            </td>

            <td class="text-right">
                Rp '.number_format(
                    $row['total_realisasi'],
                    0,
                    ",",
                    "."
                ).'
            </td>

            <td class="text-right">
                Rp '.number_format(
                    $sisa,
                    0,
                    ",",
                    "."
                ).'
            </td>

            <td class="text-center">
                '.number_format($persen,2).'%
            </td>

        </tr>
        ';
    }

}else{

    $html .= '
    <tr>
        <td colspan="6" class="text-center">
            Belum terdapat data realisasi anggaran.
        </td>
    </tr>
    ';
}

$html .= '
    </tbody>
</table>

<div class="footer">

    <div class="signature">

        <p>Purwadana, '.date('d F Y').'</p>
        <p>Kepala Desa Purwadana</p>

        <br><br><br><br>

        <p>
            <strong>
                _______________________
            </strong>
        </p>

    </div>

</div>


</body>
</html>
';

// =========================================
// Generate PDF
// =========================================

$options = new Options();
$options->set('isRemoteEnabled', true);

$dompdf = new Dompdf($options);

$dompdf->loadHtml($html);

$dompdf->setPaper('A4', 'portrait');

$dompdf->render();

$dompdf->stream(
    "laporan-realisasi-anggaran.pdf",
    [
        "Attachment" => false
    ]
);

?>