<?php
require_once '../config/database.php';
require_once '../includes/functions.php';
require_once '../includes/auth.php';
requireRole('admin');

// Pagination setup
$limit = 50;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
$offset = ($page - 1) * $limit;

// Fetch total count
$stmtTotal = $pdo->query("SELECT COUNT(*) FROM log_aktivitas");
$totalLogs = $stmtTotal->fetchColumn();
$totalPages = ceil($totalLogs / $limit);

// Fetch logs
$stmt = $pdo->prepare("SELECT l.*, u.nama, u.role FROM log_aktivitas l LEFT JOIN user u ON l.id_user = u.id_user ORDER BY l.id_log DESC LIMIT ? OFFSET ?");
$stmt->bindValue(1, $limit, PDO::PARAM_INT);
$stmt->bindValue(2, $offset, PDO::PARAM_INT);
$stmt->execute();
$logs = $stmt->fetchAll();

require_once '../includes/sidebar_admin.php';
?>

<div class="flex justify-between items-center mb-8">
    <div>
        <h2 class="text-2xl font-bold text-navy-900">Log Aktivitas</h2>
        <p class="text-slate-500">Jejak rekaman seluruh aktivitas di dalam sistem</p>
    </div>
</div>

<div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Waktu</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase">User</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Role</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Aktivitas</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                <?php foreach($logs as $log): ?>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                        <?php echo date('d M Y, H:i', strtotime($log['waktu'])); ?>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-navy-900">
                        <?php echo htmlspecialchars($log['nama'] ?? 'System Auto'); ?>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <?php if($log['role']): ?>
                            <span class="px-2 py-1 text-[10px] font-medium bg-slate-100 text-slate-600 rounded uppercase">
                                <?php echo str_replace('_', ' ', $log['role']); ?>
                            </span>
                        <?php else: ?>
                            <span class="text-xs text-slate-400">-</span>
                        <?php endif; ?>
                    </td>
                    <td class="px-6 py-4 text-sm text-slate-600">
                        <?php echo htmlspecialchars($log['aktivitas']); ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    
    <?php if($totalPages > 1): ?>
    <div class="p-4 border-t border-slate-200 flex items-center justify-between">
        <div class="text-sm text-slate-500">
            Menampilkan <?php echo $offset + 1; ?> sampai <?php echo min($offset + $limit, $totalLogs); ?> dari <?php echo $totalLogs; ?> entri
        </div>
        <div class="flex gap-2">
            <?php if($page > 1): ?>
                <a href="?page=<?php echo $page-1; ?>" class="px-3 py-1 border border-slate-300 rounded text-sm font-medium text-slate-700 bg-white hover:bg-slate-50">Sebelumnya</a>
            <?php endif; ?>
            
            <?php if($page < $totalPages): ?>
                <a href="?page=<?php echo $page+1; ?>" class="px-3 py-1 border border-slate-300 rounded text-sm font-medium text-slate-700 bg-white hover:bg-slate-50">Selanjutnya</a>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>
</div>

<?php require_once '../includes/dashboard_footer.php'; ?>
