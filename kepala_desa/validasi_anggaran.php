<?php
require_once '../config/database.php';
require_once '../includes/functions.php';
require_once '../includes/auth.php';
requireRole('kepala_desa');

$success = '';
$error = '';

if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $action = $_GET['action'];
    
    if (in_array($action, ['APPROVED', 'REJECTED'])) {
        $stmt = $pdo->prepare("UPDATE anggaran SET status = ? WHERE id_anggaran = ?");
        $stmt->execute([$action, $id]);
        
        $statusText = $action == 'APPROVED' ? 'menyetujui' : 'menolak';
        logAktivitas($pdo, $_SESSION['user_id'], ucfirst($statusText) . " anggaran ID: $id");
        $success = "Anggaran berhasil di-" . strtolower($statusText) . ".";
    }
}

// Fetch Pending Anggaran
$stmt = $pdo->query("SELECT a.*, u.nama as pembuat FROM anggaran a LEFT JOIN user u ON a.id_user = u.id_user WHERE a.status = 'PENDING' ORDER BY a.tanggal ASC");
$anggaranPending = $stmt->fetchAll();

require_once '../includes/sidebar_kepala_desa.php';
?>

<div class="flex justify-between items-center mb-8">
    <div>
        <h2 class="text-2xl font-bold text-navy-900">Validasi Anggaran</h2>
        <p class="text-slate-500">Tinjau dan berikan persetujuan untuk rencana anggaran baru</p>
    </div>
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
    <?php if(count($anggaranPending) > 0): ?>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Kegiatan</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Jumlah Diajukan</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Tanggal</th>
                    <th class="px-6 py-3 text-center text-xs font-semibold text-slate-500 uppercase">Aksi Validasi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                <?php foreach($anggaranPending as $item): ?>
                <tr>
                    <td class="px-6 py-4">
                        <div class="text-sm font-medium text-navy-900"><?php echo htmlspecialchars($item['nama_kegiatan']); ?></div>
                        <div class="text-xs text-slate-500">Diajukan oleh: <?php echo htmlspecialchars($item['pembuat'] ?? 'Sistem'); ?></div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-navy-900">
                        <?php echo formatRupiah($item['jumlah_anggaran']); ?>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                        <?php echo date('d M Y', strtotime($item['tanggal'])); ?>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <div class="flex items-center justify-center gap-2">
                            <a href="validasi_anggaran.php?action=APPROVED&id=<?php echo $item['id_anggaran']; ?>" onclick="return confirm('Setujui anggaran ini?')" class="bg-green-100 text-green-700 hover:bg-green-200 px-3 py-1.5 rounded-lg text-sm font-medium transition-colors flex items-center">
                                <i data-lucide="check" class="h-4 w-4 mr-1"></i> Setuju
                            </a>
                            <a href="validasi_anggaran.php?action=REJECTED&id=<?php echo $item['id_anggaran']; ?>" onclick="return confirm('Tolak anggaran ini?')" class="bg-red-100 text-red-700 hover:bg-red-200 px-3 py-1.5 rounded-lg text-sm font-medium transition-colors flex items-center">
                                <i data-lucide="x" class="h-4 w-4 mr-1"></i> Tolak
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php else: ?>
    <div class="p-12 text-center">
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-100 mb-4">
            <i data-lucide="check-circle" class="h-8 w-8 text-slate-400"></i>
        </div>
        <h3 class="text-lg font-medium text-navy-900 mb-1">Semua Selesai</h3>
        <p class="text-slate-500">Tidak ada pengajuan anggaran yang menunggu validasi.</p>
    </div>
    <?php endif; ?>
</div>

<?php require_once '../includes/dashboard_footer.php'; ?>
