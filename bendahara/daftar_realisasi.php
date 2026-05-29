<?php
require_once '../config/database.php';
require_once '../includes/functions.php';
require_once '../includes/auth.php';
requireRole('bendahara');

$success = '';
$error = '';

// Handle Delete
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $pdo->prepare("SELECT status FROM realisasi WHERE id_realisasi = ?");
    $stmt->execute([$id]);
    $realisasi = $stmt->fetch();
    
    if ($realisasi && $realisasi['status'] === 'PENDING') {
        $stmt = $pdo->prepare("DELETE FROM realisasi WHERE id_realisasi = ?");
        $stmt->execute([$id]);
        logAktivitas($pdo, $_SESSION['user_id'], "Menghapus realisasi PENDING dengan ID: $id");
        $success = "Realisasi berhasil dihapus.";
    } else {
        $error = "Hanya realisasi berstatus PENDING yang dapat dihapus.";
    }
}

// Fetch Realisasi List
$stmt = $pdo->query("SELECT r.*, a.nama_kegiatan, a.jumlah_anggaran FROM realisasi r LEFT JOIN anggaran a ON r.id_anggaran = a.id_anggaran ORDER BY r.id_realisasi DESC");
$realisasiList = $stmt->fetchAll();

require_once '../includes/sidebar_bendahara.php';
?>

<div class="flex justify-between items-center mb-8">
    <div>
        <h2 class="text-2xl font-bold text-navy-900">Daftar Realisasi</h2>
        <p class="text-slate-500">Seluruh catatan pengeluaran realisasi dana desa</p>
    </div>
    <a href="input_realisasi.php" class="bg-primary hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium flex items-center transition-colors shadow-sm">
        <i data-lucide="plus" class="h-4 w-4 mr-2"></i> Input Realisasi
    </a>
</div>

<?php if($error): ?>
    <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-md">
        <p class="text-sm text-red-700"><?php echo $error; ?></p>
    </div>
<?php endif; ?>

<?php if($success): ?>
    <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded-md">
        <p class="text-sm text-green-700"><?php echo $success; ?></p>
    </div>
<?php endif; ?>

<div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Kegiatan Anggaran</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Jumlah Anggaran</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Jumlah Realisasi</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Tanggal</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-slate-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                <?php foreach($realisasiList as $item): ?>
                <tr>
                    <td class="px-6 py-4">
                        <div class="text-sm font-medium text-navy-900"><?php echo htmlspecialchars($item['nama_kegiatan'] ?? 'N/A'); ?></div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                        <?php echo formatRupiah($item['jumlah_anggaran'] ?? 0); ?>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-slate-700">
                        <?php echo formatRupiah($item['jumlah_realisasi']); ?>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                        <?php echo date('d/m/Y', strtotime($item['tanggal'])); ?>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <?php if($item['status'] == 'APPROVED'): ?>
                            <span class="px-2.5 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full flex items-center inline-flex">
                                <i data-lucide="check-circle" class="h-3 w-3 mr-1"></i> Disetujui
                            </span>
                        <?php elseif($item['status'] == 'REJECTED'): ?>
                            <span class="px-2.5 py-1 text-xs font-medium bg-red-100 text-red-800 rounded-full flex items-center inline-flex">
                                <i data-lucide="x-circle" class="h-3 w-3 mr-1"></i> Ditolak
                            </span>
                        <?php else: ?>
                            <span class="px-2.5 py-1 text-xs font-medium bg-yellow-100 text-yellow-800 rounded-full flex items-center inline-flex">
                                <i data-lucide="clock" class="h-3 w-3 mr-1"></i> Menunggu
                            </span>
                        <?php endif; ?>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                        <?php if($item['status'] == 'PENDING'): ?>
                            <a href="daftar_realisasi.php?delete=<?php echo $item['id_realisasi']; ?>" onclick="return confirm('Yakin ingin menghapus realisasi ini?')" class="text-red-500 hover:text-red-700 font-medium">Hapus</a>
                        <?php else: ?>
                            <span class="text-slate-300 cursor-not-allowed">Hapus</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once '../includes/dashboard_footer.php'; ?>
