<?php
require_once '../config/database.php';
require_once '../includes/functions.php';
require_once '../includes/auth.php';
requireRole('bendahara');

// Fetch summary data
$stmt = $pdo->query("SELECT SUM(jumlah_anggaran) as total FROM anggaran WHERE status = 'APPROVED'");
$totalAnggaran = $stmt->fetch()['total'] ?? 0;

$stmt = $pdo->query("SELECT SUM(jumlah_realisasi) as total FROM realisasi WHERE status = 'APPROVED'");
$totalSpending = $stmt->fetch()['total'] ?? 0;

$stmt = $pdo->query("SELECT SUM(jumlah_realisasi) as total FROM realisasi WHERE status = 'PENDING'");
$pendingRealisasi = $stmt->fetch()['total'] ?? 0;

$persentase = $totalAnggaran > 0 ? round(($totalSpending / $totalAnggaran) * 100) : 0;

// Fetch latest realisasi
$stmt = $pdo->query("SELECT r.*, a.nama_kegiatan FROM realisasi r JOIN anggaran a ON r.id_anggaran = a.id_anggaran ORDER BY r.id_realisasi DESC LIMIT 4");
$realisasis = $stmt->fetchAll();

// Fetch approved anggaran for dropdown
$stmt = $pdo->query("SELECT * FROM anggaran WHERE status = 'APPROVED'");
$anggarans = $stmt->fetchAll();

require_once '../includes/sidebar_bendahara.php';
?>

<!-- Sambutan -->
<div class="mb-8">
    <h2 class="text-2xl font-bold text-navy-900">Ringkasan Keuangan</h2>
    <p class="text-slate-500">Selamat datang kembali, <?php echo htmlspecialchars($_SESSION['nama'] ?? 'Bendahara'); ?>. Pantau dan input realisasi anggaran hari ini.</p>
</div>

<!-- Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
    <div class="bg-white rounded-xl p-6 border border-slate-200 shadow-sm relative overflow-hidden">
        <p class="text-sm font-medium text-slate-500 mb-1">Pending Realisasi</p>
        <h3 class="text-3xl font-bold text-navy-900 mb-4"><?php echo formatRupiah($pendingRealisasi); ?></h3>
        <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">
            <i data-lucide="clock" class="h-3 w-3 mr-1"></i> Butuh Approval
        </span>
        <div class="absolute right-6 top-6 h-12 w-12 bg-red-50 text-red-400 rounded-xl flex items-center justify-center">
            <i data-lucide="calendar-clock" class="h-6 w-6"></i>
        </div>
    </div>
    
    <div class="bg-white rounded-xl p-6 border border-slate-200 shadow-sm relative overflow-hidden">
        <p class="text-sm font-medium text-slate-500 mb-1">Total Spending (YTD)</p>
        <h3 class="text-3xl font-bold text-navy-900 mb-4"><?php echo formatRupiah($totalSpending); ?></h3>
        <div class="flex items-center justify-between text-xs font-medium text-primary mb-1">
            <span>Progress</span>
            <span><?php echo $persentase; ?>%</span>
        </div>
        <div class="w-full bg-slate-100 rounded-full h-1.5">
            <div class="bg-primary h-1.5 rounded-full" style="width: <?php echo $persentase; ?>%"></div>
        </div>
        <div class="absolute right-6 top-6 h-12 w-12 bg-blue-50 text-primary rounded-xl flex items-center justify-center">
            <i data-lucide="wallet" class="h-6 w-6"></i>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Form Input Realisasi -->
    <div class="lg:col-span-1 bg-white rounded-xl border border-slate-200 shadow-sm flex flex-col">
        <div class="p-6 border-b border-slate-200 flex items-center">
            <i data-lucide="plus-circle" class="h-5 w-5 text-primary mr-2"></i>
            <h3 class="text-lg font-bold text-navy-900">Input Realisasi</h3>
        </div>
        <div class="p-6">
            <form action="input_realisasi.php" method="POST" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Pilih Anggaran Disetujui</label>
                    <select name="id_anggaran" required class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary p-2.5 border text-sm text-slate-700">
                        <option value="">Pilih kegiatan yang telah disetujui...</option>
                        <?php foreach($anggarans as $a): ?>
                            <option value="<?php echo $a['id_anggaran']; ?>"><?php echo htmlspecialchars($a['nama_kegiatan']); ?> (<?php echo formatRupiah($a['jumlah_anggaran']); ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Jumlah Realisasi</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-slate-500 sm:text-sm font-medium">Rp</span>
                        </div>
                        <input type="text" name="jumlah_realisasi" required class="w-full pl-10 border-slate-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary p-2.5 border text-sm" placeholder="Masukkan jumlah dana..." inputmode="numeric" pattern="[0-9.]*">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Tanggal</label>
                    <input type="date" name="tanggal" required class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary p-2.5 border text-sm">
                </div>
                <div class="pt-2">
                    <button type="submit" class="w-full bg-navy-800 text-white py-2.5 rounded-lg font-medium hover:bg-navy-900 transition-colors flex justify-center items-center text-sm shadow-sm">
                        <i data-lucide="send" class="h-4 w-4 mr-2"></i> Submit to Kepala Desa
                    </button>
                    <p class="text-[10px] text-center text-slate-400 mt-2">*Data akan dikirim ke Kepala Desa untuk verifikasi akhir.</p>
                </div>
            </form>
        </div>
    </div>

    <!-- Riwayat Realisasi -->
    <div class="lg:col-span-2 bg-white rounded-xl border border-slate-200 shadow-sm flex flex-col">
        <div class="p-6 border-b border-slate-200 flex justify-between items-center">
            <div class="flex items-center">
                <i data-lucide="history" class="h-5 w-5 text-primary mr-2"></i>
                <h3 class="text-lg font-bold text-navy-900">Riwayat Realisasi Terbaru</h3>
            </div>
            <a href="daftar_realisasi.php" class="text-primary text-sm font-semibold hover:underline">Lihat Semua</a>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Kegiatan</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Jumlah</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-slate-500 uppercase">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    <?php foreach($realisasis as $r): ?>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <p class="text-sm font-medium text-navy-900"><?php echo htmlspecialchars($r['nama_kegiatan']); ?></p>
                            <p class="text-xs text-slate-400">ID: #RE-<?php echo 90000 + $r['id_realisasi']; ?></p>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700">
                            <?php echo formatRupiah($r['jumlah_realisasi']); ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <?php if($r['status'] == 'PENDING'): ?>
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-50 text-red-700 border border-red-100"><span class="h-1.5 w-1.5 bg-red-600 rounded-full mr-1.5"></span> PENDING</span>
                            <?php elseif($r['status'] == 'APPROVED'): ?>
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-50 text-green-700 border border-green-100"><span class="h-1.5 w-1.5 bg-green-600 rounded-full mr-1.5"></span> APPROVED</span>
                            <?php else: ?>
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-700 border border-slate-200"><span class="h-1.5 w-1.5 bg-slate-400 rounded-full mr-1.5"></span> <?php echo $r['status']; ?></span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-slate-100 bg-slate-50 text-xs text-slate-500 flex justify-between items-center rounded-b-xl">
            <span>Menampilkan <?php echo count($realisasis); ?> entri terbaru</span>
            <div class="flex gap-1 text-slate-400">
                <i data-lucide="chevron-left" class="h-4 w-4"></i>
                <i data-lucide="chevron-right" class="h-4 w-4"></i>
            </div>
        </div>
    </div>
</div>

<?php require_once '../includes/dashboard_footer.php'; ?>
