<?php
require_once '../config/database.php';
require_once '../includes/functions.php';
require_once '../includes/auth.php';
requireRole('kepala_desa');

// Fetch summary metrics
$stmt = $pdo->query("SELECT SUM(jumlah_anggaran) as total FROM anggaran WHERE status = 'APPROVED'");
$totalAnggaran = $stmt->fetch()['total'] ?? 0;

$stmt = $pdo->query("SELECT SUM(jumlah_realisasi) as total FROM realisasi WHERE status = 'APPROVED'");
$totalRealisasi = $stmt->fetch()['total'] ?? 0;

$sisaAnggaran = $totalAnggaran - $totalRealisasi;

// Fetch all approved budgets and their realizations
$stmt = $pdo->query("SELECT a.id_anggaran, a.nama_kegiatan, a.jumlah_anggaran, COALESCE(SUM(r.jumlah_realisasi), 0) as total_realisasi FROM anggaran a LEFT JOIN realisasi r ON a.id_anggaran = r.id_anggaran AND r.status = 'APPROVED' WHERE a.status = 'APPROVED' GROUP BY a.id_anggaran, a.nama_kegiatan, a.jumlah_anggaran");
$laporanDetail = $stmt->fetchAll();

require_once '../includes/sidebar_kepala_desa.php';
?>

<div class="flex justify-between items-center mb-8">
    <div>
        <h2 class="text-2xl font-bold text-navy-900">Monitoring Laporan</h2>
        <p class="text-slate-500">Pantau performa penyerapan anggaran dan rincian keuangan desa</p>
    </div>
    <a href="../laporan.php" target="_blank" class="bg-primary hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium flex items-center transition-colors shadow-sm">
        <i data-lucide="external-link" class="h-4 w-4 mr-2"></i> Laporan Publik
    </a>
</div>

<!-- Summary Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-xl p-6 border border-slate-200 shadow-sm flex flex-col justify-center">
        <div class="flex items-center text-slate-500 mb-2">
            <i data-lucide="wallet" class="h-5 w-5 mr-2"></i>
            <span class="text-sm font-medium">Total Anggaran Disetujui</span>
        </div>
        <h3 class="text-3xl font-bold text-navy-900"><?php echo formatRupiah($totalAnggaran); ?></h3>
    </div>
    <div class="bg-white rounded-xl p-6 border border-slate-200 shadow-sm flex flex-col justify-center">
        <div class="flex items-center text-primary mb-2">
            <i data-lucide="trending-up" class="h-5 w-5 mr-2"></i>
            <span class="text-sm font-medium">Total Realisasi Disetujui</span>
        </div>
        <h3 class="text-3xl font-bold text-primary"><?php echo formatRupiah($totalRealisasi); ?></h3>
    </div>
    <div class="bg-white rounded-xl p-6 border border-slate-200 shadow-sm flex flex-col justify-center">
        <div class="flex items-center text-green-600 mb-2">
            <i data-lucide="pie-chart" class="h-5 w-5 mr-2"></i>
            <span class="text-sm font-medium">Sisa Anggaran</span>
        </div>
        <h3 class="text-3xl font-bold text-green-600"><?php echo formatRupiah($sisaAnggaran); ?></h3>
    </div>
</div>

<!-- Table -->
<div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="p-6 border-b border-slate-200 flex justify-between items-center bg-slate-50">
        <h3 class="text-lg font-bold text-navy-900">Rincian Penyerapan per Kegiatan</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-white">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase">Nama Kegiatan</th>
                    <th class="px-6 py-4 text-right text-xs font-semibold text-slate-500 uppercase">Pagu Anggaran</th>
                    <th class="px-6 py-4 text-right text-xs font-semibold text-slate-500 uppercase">Realisasi</th>
                    <th class="px-6 py-4 text-right text-xs font-semibold text-slate-500 uppercase">Sisa / Lebih</th>
                    <th class="px-6 py-4 text-center text-xs font-semibold text-slate-500 uppercase">Persentase</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <?php foreach($laporanDetail as $detail): 
                    $sisa = $detail['jumlah_anggaran'] - $detail['total_realisasi'];
                    $persentase = $detail['jumlah_anggaran'] > 0 ? ($detail['total_realisasi'] / $detail['jumlah_anggaran']) * 100 : 0;
                ?>
                <tr>
                    <td class="px-6 py-4 text-sm font-medium text-navy-900">
                        <?php echo htmlspecialchars($detail['nama_kegiatan']); ?>
                    </td>
                    <td class="px-6 py-4 text-right text-sm text-slate-600">
                        <?php echo formatRupiah($detail['jumlah_anggaran']); ?>
                    </td>
                    <td class="px-6 py-4 text-right text-sm text-slate-600 font-semibold">
                        <?php echo formatRupiah($detail['total_realisasi']); ?>
                    </td>
                    <td class="px-6 py-4 text-right text-sm <?php echo $sisa < 0 ? 'text-red-500' : 'text-green-600'; ?>">
                        <?php echo formatRupiah($sisa); ?>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex items-center justify-center">
                            <div class="w-full bg-slate-200 rounded-full h-2.5 mr-2 max-w-[100px]">
                                <div class="bg-primary h-2.5 rounded-full" style="width: <?php echo min(100, $persentase); ?>%"></div>
                            </div>
                            <span class="text-xs font-medium text-slate-600"><?php echo number_format($persentase, 1); ?>%</span>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once '../includes/dashboard_footer.php'; ?>
