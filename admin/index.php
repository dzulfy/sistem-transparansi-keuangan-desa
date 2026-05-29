<?php
require_once '../config/database.php';
require_once '../includes/functions.php';
require_once '../includes/auth.php';
requireRole('admin');

// Fetch summary data
$stmt = $pdo->query("SELECT COUNT(*) as total FROM user");
$totalUsers = $stmt->fetch()['total'];

$stmt = $pdo->query("SELECT SUM(jumlah_anggaran) as total FROM anggaran WHERE status = 'PENDING'");
$totalPendingBudget = $stmt->fetch()['total'] ?? 0;

// Fetch latest users
$stmt = $pdo->query("SELECT * FROM user ORDER BY id_user DESC LIMIT 5");
$users = $stmt->fetchAll();

// Fetch latest logs
$stmt = $pdo->query("SELECT log_aktivitas.*, user.nama FROM log_aktivitas LEFT JOIN user ON log_aktivitas.id_user = user.id_user ORDER BY id_log DESC LIMIT 5");
$logs = $stmt->fetchAll();

require_once '../includes/sidebar_admin.php';
?>

<div class="flex justify-between items-center mb-8">
    <div>
        <h2 class="text-2xl font-bold text-navy-900">Dashboard Administrasi</h2>
        <p class="text-slate-500">Kelola data keuangan dan akses pengguna desa.</p>
    </div>
    <a href="log_aktivitas.php" class="bg-navy-800 hover:bg-navy-900 text-white px-4 py-2 rounded-lg font-medium flex items-center transition-colors shadow-sm">
        <i data-lucide="history" class="h-4 w-4 mr-2"></i> Log Aktivitas
    </a>
</div>

<!-- Summary Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
    <div class="bg-white rounded-xl p-6 border border-slate-200 shadow-sm flex items-center">
        <div class="h-14 w-14 bg-blue-100 text-primary rounded-full flex items-center justify-center mr-4">
            <i data-lucide="users" class="h-6 w-6"></i>
        </div>
        <div>
            <p class="text-sm font-medium text-slate-500">Total Users</p>
            <div class="flex items-baseline">
                <h3 class="text-3xl font-bold text-navy-900 mr-2"><?php echo $totalUsers; ?></h3>
                <span class="text-sm text-slate-500">Aktif</span>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-xl p-6 border border-slate-200 shadow-sm flex items-center">
        <div class="h-14 w-14 bg-slate-100 text-slate-600 rounded-full flex items-center justify-center mr-4">
            <i data-lucide="clock" class="h-6 w-6"></i>
        </div>
        <div>
            <p class="text-sm font-medium text-slate-500">Total Pending Budget</p>
            <h3 class="text-3xl font-bold text-navy-900"><?php echo formatRupiah($totalPendingBudget); ?></h3>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 xl:grid-cols-2 gap-8">
    <!-- Kelola User (Mini) -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm flex flex-col">
        <div class="p-6 border-b border-slate-200 flex justify-between items-center">
            <h3 class="text-lg font-bold text-navy-900">Kelola User</h3>
            <a href="kelola_user.php" class="text-primary hover:text-blue-700 text-sm font-medium flex items-center">
                <i data-lucide="user-plus" class="h-4 w-4 mr-1"></i> Add User
            </a>
        </div>
        <div class="flex-1 overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Username</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Peran</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-slate-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    <?php foreach($users as $u): ?>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-navy-900"><?php echo htmlspecialchars($u['nama']); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500"><?php echo htmlspecialchars($u['username']); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <?php if($u['role'] == 'admin'): ?>
                                <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-md">ADMIN</span>
                            <?php elseif($u['role'] == 'bendahara'): ?>
                                <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-md">BENDAHARA</span>
                            <?php else: ?>
                                <span class="px-2 py-1 text-xs font-medium bg-slate-100 text-slate-800 rounded-md uppercase"><?php echo str_replace('_', ' ', $u['role']); ?></span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                            <a href="kelola_user.php" class="text-slate-400 hover:text-primary"><i data-lucide="pencil" class="h-4 w-4 inline"></i></a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Input Anggaran (Quick Form) -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm flex flex-col">
        <div class="p-6 border-b border-slate-200">
            <h3 class="text-lg font-bold text-navy-900">Input Anggaran</h3>
        </div>
        <div class="p-6 flex-1">
            <form action="input_anggaran.php" method="POST" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Nama Kegiatan</label>
                    <input type="text" name="nama_kegiatan" required class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary p-2 border" placeholder="Contoh: Pembangunan Jembatan">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Jumlah Anggaran</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-slate-500 sm:text-sm">Rp</span>
                        </div>
                        <input type="number" name="jumlah_anggaran" required class="w-full pl-10 border-slate-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary p-2 border" placeholder="0">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Tanggal</label>
                    <input type="date" name="tanggal" required class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary p-2 border">
                </div>
                <button type="submit" class="w-full bg-primary text-white py-2 rounded-lg font-medium hover:bg-blue-700 transition-colors flex justify-center items-center">
                    <i data-lucide="save" class="h-4 w-4 mr-2"></i> Simpan Anggaran
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Log Aktivitas -->
<div class="mt-8 bg-white rounded-xl border border-slate-200 shadow-sm">
    <div class="p-6 border-b border-slate-200 flex justify-between items-center">
        <h3 class="text-lg font-bold text-navy-900">Log Aktivitas System Audit</h3>
        <i data-lucide="shield-check" class="h-5 w-5 text-slate-400"></i>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Waktu</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase">User</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Aktivitas</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                <?php foreach($logs as $log): ?>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500"><?php echo date('Y-m-d H:i:s', strtotime($log['waktu'])); ?></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-navy-900"><?php echo htmlspecialchars($log['nama'] ?? 'System Auto'); ?></td>
                    <td class="px-6 py-4 text-sm text-slate-600"><?php echo htmlspecialchars($log['aktivitas']); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="p-4 border-t border-slate-200 text-center">
        <a href="log_aktivitas.php" class="text-primary text-sm font-medium hover:underline">Lihat Seluruh Log Aktivitas</a>
    </div>
</div>

<?php require_once '../includes/dashboard_footer.php'; ?>
