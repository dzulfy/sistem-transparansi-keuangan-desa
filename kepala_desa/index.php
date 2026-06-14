<?php
require_once '../config/database.php';
require_once '../includes/functions.php';
require_once '../includes/auth.php';
requireRole('kepala_desa');

// Counts for badges
$stmt = $pdo->query("SELECT COUNT(*) as total FROM anggaran WHERE status = 'PENDING'");
$countPendingAnggaran = $stmt->fetch()['total'];

$stmt = $pdo->query("SELECT COUNT(*) as total FROM realisasi WHERE status = 'PENDING'");
$countPendingRealisasi = $stmt->fetch()['total'];

// Summaries
$stmt = $pdo->query("SELECT SUM(jumlah_anggaran) as total FROM anggaran WHERE status = 'APPROVED'");
$totalAnggaranDisetujui = $stmt->fetch()['total'] ?? 0;

$stmt = $pdo->query("SELECT SUM(jumlah_realisasi) as total FROM realisasi WHERE status = 'APPROVED'");
$totalRealisasiCair = $stmt->fetch()['total'] ?? 0;

$persentaseRealisasi = $totalAnggaranDisetujui > 0 ? round(($totalRealisasiCair / $totalAnggaranDisetujui) * 100) : 0;

// Fetch pending antrian
$stmt = $pdo->query("SELECT a.*, u.nama as pengirim FROM anggaran a JOIN user u ON a.id_user = u.id_user WHERE a.status = 'PENDING' ORDER BY a.tanggal ASC LIMIT 3");
$antrianAnggaran = $stmt->fetchAll();

$stmt = $pdo->query("SELECT r.*, a.nama_kegiatan, u.nama as pengirim FROM realisasi r JOIN anggaran a ON r.id_anggaran = a.id_anggaran JOIN user u ON a.id_user = u.id_user WHERE r.status = 'PENDING' ORDER BY r.tanggal ASC LIMIT 3");
$antrianRealisasi = $stmt->fetchAll();

require_once '../includes/sidebar_kepala_desa.php';
?>

<div class="mb-8">
    <p class="text-slate-500 mb-6">Tinjau dan validasi dokumen keuangan desa untuk transparansi publik.</p>
</div>

<!-- Antrian Tables Row -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
    <!-- Antrian Anggaran -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm flex flex-col overflow-hidden">
        <div class="p-5 border-b border-slate-200 flex justify-between items-center bg-slate-50/50">
            <div class="flex items-center">
                <i data-lucide="check-square" class="h-5 w-5 text-primary mr-2"></i>
                <h3 class="font-semibold text-navy-900">Antrian Validasi Anggaran</h3>
            </div>
            <?php if($countPendingAnggaran > 0): ?>
                <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-primary text-white"><?php echo $countPendingAnggaran; ?> Menunggu</span>
            <?php endif; ?>
        </div>
        <div class="overflow-x-auto flex-1">
            <table class="min-w-full divide-y divide-slate-100">
                <thead class="bg-slate-100/50">
                    <tr>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-slate-600">Nama Kegiatan</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-slate-600">Jumlah (Rp)</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-slate-600">Tanggal</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-slate-600">Pengirim</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php foreach($antrianAnggaran as $a): ?>
                    <tr>
                        <td class="px-5 py-4 text-sm font-semibold text-navy-900"><?php echo htmlspecialchars($a['nama_kegiatan']); ?></td>
                        <td class="px-5 py-4 text-sm text-primary"><?php echo number_format($a['jumlah_anggaran'], 0, ',', '.'); ?></td>
                        <td class="px-5 py-4 text-sm text-slate-500"><?php echo $a['tanggal']; ?></td>
                        <td class="px-5 py-4">
                            <div class="h-6 w-6 rounded-full bg-slate-200 flex items-center justify-center text-[10px] font-bold text-slate-600" title="<?php echo htmlspecialchars($a['pengirim']); ?>">
                                <?php echo strtoupper(substr($a['pengirim'], 0, 1)); ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if(count($antrianAnggaran) == 0): ?>
                    <tr><td colspan="4" class="px-5 py-4 text-center text-sm text-slate-400">Tidak ada antrian</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <a href="validasi_anggaran.php" class="block p-3 text-center text-sm font-semibold text-primary hover:bg-slate-50 border-t border-slate-100 transition-colors">Lihat Semua Antrian Anggaran</a>
    </div>

    <!-- Antrian Realisasi -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm flex flex-col overflow-hidden">
        <div class="p-5 border-b border-slate-200 flex justify-between items-center bg-slate-50/50">
            <div class="flex items-center">
                <i data-lucide="wallet" class="h-5 w-5 text-green-600 mr-2"></i>
                <h3 class="font-semibold text-navy-900">Antrian Validasi Realisasi</h3>
            </div>
            <?php if($countPendingRealisasi > 0): ?>
                <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-700 text-white"><?php echo $countPendingRealisasi; ?> Mendesak</span>
            <?php endif; ?>
        </div>
        <div class="overflow-x-auto flex-1">
            <table class="min-w-full divide-y divide-slate-100">
                <thead class="bg-slate-100/50">
                    <tr>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-slate-600">Nama Kegiatan</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-slate-600">Jumlah (Rp)</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-slate-600">Tanggal</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-slate-600">Pengirim</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php foreach($antrianRealisasi as $r): ?>
                    <tr>
                        <td class="px-5 py-4 text-sm font-semibold text-navy-900 leading-tight">
                            <?php echo htmlspecialchars($r['nama_kegiatan']); ?>
                        </td>
                        <td class="px-5 py-4 text-sm text-primary"><?php echo number_format($r['jumlah_realisasi'], 0, ',', '.'); ?></td>
                        <td class="px-5 py-4 text-sm text-slate-500"><?php echo $r['tanggal']; ?></td>
                        <td class="px-5 py-4 flex items-center">
                            <div class="h-6 w-6 rounded-full bg-slate-200 flex items-center justify-center text-[10px] font-bold text-slate-600 mr-2" title="<?php echo htmlspecialchars($r['pengirim']); ?>">
                                B
                            </div>
                            <span class="text-xs text-slate-500">Benda...</span>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if(count($antrianRealisasi) == 0): ?>
                    <tr><td colspan="4" class="px-5 py-4 text-center text-sm text-slate-400">Tidak ada antrian</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <a href="validasi_realisasi.php" class="block p-3 text-center text-sm font-semibold text-primary hover:bg-slate-50 border-t border-slate-100 transition-colors">Lihat Semua Antrian Realisasi</a>
    </div>
</div>

<!-- Summary Cards Bottom -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="bg-blue-50/50 rounded-xl p-6 border border-blue-100">
        <p class="text-sm font-medium text-slate-500 mb-2">Total Anggaran Disetujui</p>
        <h3 class="text-2xl font-bold text-primary mb-2"><?php echo formatRupiah($totalAnggaranDisetujui); ?></h3>
        <p class="text-xs font-medium text-slate-500 flex items-center">
            <i data-lucide="info" class="h-3.5 w-3.5 mr-1 text-blue-500"></i> Pagu belanja disetujui
        </p>
    </div>
    <div class="bg-slate-50 rounded-xl p-6 border border-slate-200">
        <p class="text-sm font-medium text-slate-500 mb-2">Total Realisasi Cair</p>
        <h3 class="text-2xl font-bold text-green-700 mb-2"><?php echo formatRupiah($totalRealisasiCair); ?></h3>
        <p class="text-xs font-medium text-slate-500 flex items-center">
            <i data-lucide="check-circle" class="h-3.5 w-3.5 mr-1 text-green-600"></i> Dana terserap oleh kegiatan
        </p>
    </div>
    <div class="bg-navy-800 rounded-xl p-6 text-white relative overflow-hidden flex flex-col justify-between shadow-md">
        <div class="relative z-10">
            <p class="text-sm text-blue-200 mb-1">Laporan Akuntabilitas</p>
            <p class="text-lg font-medium mb-4"><?php echo $persentaseRealisasi; ?>% Anggaran Terserap</p>
            <a href="monitoring_laporan.php" class="bg-primary hover:bg-blue-600 text-white text-xs font-semibold px-4 py-2 rounded-full transition-colors inline-block">
                Unduh Laporan PDF
            </a>
        </div>
        <i data-lucide="bar-chart-2" class="absolute -right-4 -bottom-4 h-32 w-32 text-navy-900 opacity-50 transform -rotate-12"></i>
    </div>
</div>

<?php require_once '../includes/dashboard_footer.php'; ?>
