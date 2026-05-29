<?php
require_once '../config/database.php';
require_once '../includes/functions.php';
require_once '../includes/auth.php';
requireRole('bendahara');

$error = '';
$success = '';

// Fetch only APPROVED budgets that do not have a pending or approved realization
// We can just fetch all APPROVED budgets for simplicity, and let them add realization.
$stmt = $pdo->query("SELECT * FROM anggaran WHERE status = 'APPROVED' ORDER BY id_anggaran DESC");
$anggaranList = $stmt->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_anggaran = (int)$_POST['id_anggaran'];
    $jumlah_realisasi = floatval($_POST['jumlah_realisasi']);
    $tanggal = $_POST['tanggal'];
    
    if (empty($id_anggaran) || $jumlah_realisasi <= 0 || empty($tanggal)) {
        $error = "Semua field wajib diisi dan jumlah harus lebih dari 0.";
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO realisasi (id_anggaran, jumlah_realisasi, tanggal, status) VALUES (?, ?, ?, 'PENDING')");
            $stmt->execute([$id_anggaran, $jumlah_realisasi, $tanggal]);
            logAktivitas($pdo, $_SESSION['user_id'], "Input realisasi baru untuk anggaran ID: $id_anggaran (Rp " . number_format($jumlah_realisasi, 0, ',', '.') . ")");
            $success = "Realisasi berhasil disimpan dan menunggu validasi Kepala Desa.";
        } catch(PDOException $e) {
            $error = "Terjadi kesalahan saat menyimpan realisasi.";
        }
    }
}

require_once '../includes/sidebar_bendahara.php';
?>

<div class="flex justify-between items-center mb-8">
    <div>
        <h2 class="text-2xl font-bold text-navy-900">Input Realisasi</h2>
        <p class="text-slate-500">Form pencatatan pengeluaran riil (realisasi) dari anggaran yang disetujui</p>
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

<div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 max-w-2xl">
    <form action="input_realisasi.php" method="POST" class="space-y-6">
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Pilih Anggaran Kegiatan (Yang Disetujui)</label>
            <select name="id_anggaran" required class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary p-2.5 border">
                <option value="">-- Pilih Anggaran --</option>
                <?php foreach($anggaranList as $a): ?>
                    <option value="<?php echo $a['id_anggaran']; ?>">
                        <?php echo htmlspecialchars($a['nama_kegiatan']); ?> - <?php echo formatRupiah($a['jumlah_anggaran']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Jumlah Realisasi</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <span class="text-slate-500 font-medium">Rp</span>
                </div>
                <input type="number" name="jumlah_realisasi" required class="w-full pl-12 border-slate-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary p-2.5 border" placeholder="0">
            </div>
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Tanggal Realisasi</label>
            <input type="date" name="tanggal" required class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary p-2.5 border">
        </div>
        <div class="pt-4 border-t border-slate-100 flex gap-4">
            <button type="submit" class="bg-primary text-white px-6 py-2.5 rounded-lg font-medium hover:bg-blue-700 transition-colors flex items-center">
                <i data-lucide="save" class="h-4 w-4 mr-2"></i> Simpan Realisasi
            </button>
            <a href="daftar_realisasi.php" class="bg-slate-100 text-slate-700 px-6 py-2.5 rounded-lg font-medium hover:bg-slate-200 transition-colors flex items-center">
                Lihat Daftar Realisasi
            </a>
        </div>
    </form>
</div>

<?php require_once '../includes/dashboard_footer.php'; ?>
