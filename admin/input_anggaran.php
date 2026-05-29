<?php
require_once '../config/database.php';
require_once '../includes/functions.php';
require_once '../includes/auth.php';
requireRole('admin');

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_kegiatan = sanitize($_POST['nama_kegiatan']);
    $jumlah_anggaran = floatval($_POST['jumlah_anggaran']);
    $tanggal = $_POST['tanggal'];
    $id_user = $_SESSION['user_id'];
    
    if (empty($nama_kegiatan) || $jumlah_anggaran <= 0 || empty($tanggal)) {
        $error = "Semua field wajib diisi dan jumlah harus lebih dari 0.";
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO anggaran (nama_kegiatan, jumlah_anggaran, tanggal, id_user, status) VALUES (?, ?, ?, ?, 'PENDING')");
            $stmt->execute([$nama_kegiatan, $jumlah_anggaran, $tanggal, $id_user]);
            logAktivitas($pdo, $id_user, "Input anggaran baru: $nama_kegiatan (Rp " . number_format($jumlah_anggaran, 0, ',', '.') . ")");
            $success = "Anggaran berhasil disimpan dan menunggu validasi Kepala Desa.";
        } catch(PDOException $e) {
            $error = "Terjadi kesalahan saat menyimpan anggaran.";
        }
    }
}

require_once '../includes/sidebar_admin.php';
?>

<div class="flex justify-between items-center mb-8">
    <div>
        <h2 class="text-2xl font-bold text-navy-900">Input Anggaran</h2>
        <p class="text-slate-500">Form pengajuan rencana anggaran baru</p>
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
    <form action="input_anggaran.php" method="POST" class="space-y-6">
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Nama Kegiatan</label>
            <input type="text" name="nama_kegiatan" required class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary p-2.5 border" placeholder="Contoh: Pembangunan Jembatan Desa">
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Jumlah Anggaran</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <span class="text-slate-500 font-medium">Rp</span>
                </div>
                <input type="number" name="jumlah_anggaran" required class="w-full pl-12 border-slate-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary p-2.5 border" placeholder="0">
            </div>
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Tanggal Rencana</label>
            <input type="date" name="tanggal" required class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary p-2.5 border">
        </div>
        <div class="pt-4 border-t border-slate-100 flex gap-4">
            <button type="submit" class="bg-primary text-white px-6 py-2.5 rounded-lg font-medium hover:bg-blue-700 transition-colors flex items-center">
                <i data-lucide="save" class="h-4 w-4 mr-2"></i> Simpan Anggaran
            </button>
            <a href="daftar_anggaran.php" class="bg-slate-100 text-slate-700 px-6 py-2.5 rounded-lg font-medium hover:bg-slate-200 transition-colors flex items-center">
                Lihat Daftar Anggaran
            </a>
        </div>
    </form>
</div>

<?php require_once '../includes/dashboard_footer.php'; ?>
