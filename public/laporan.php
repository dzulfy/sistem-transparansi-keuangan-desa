<?php
require_once '../config/database.php';
require_once '../includes/functions.php';

// Tab selection: 'realtime' or 'audited'
$tab = $_GET['tab'] ?? 'realtime';

// --- DATA UNTUK TAB REAL-TIME ---
// 1. Fetch totals
$stmt = $pdo->query("SELECT SUM(jumlah_anggaran) as total FROM anggaran WHERE status = 'APPROVED'");
$totalAnggaranRealtime = $stmt->fetch()['total'] ?? 0;

$stmt = $pdo->query("SELECT SUM(jumlah_realisasi) as total FROM realisasi WHERE status = 'APPROVED'");
$totalRealisasiRealtime = $stmt->fetch()['total'] ?? 0;

$sisaAnggaranRealtime = $totalAnggaranRealtime - $totalRealisasiRealtime;

// 2. Fetch all approved activities and their realization details
$stmt = $pdo->query("
    SELECT a.id_anggaran, a.nama_kegiatan, a.jumlah_anggaran, COALESCE(SUM(r.jumlah_realisasi), 0) as total_realisasi 
    FROM anggaran a 
    LEFT JOIN realisasi r ON a.id_anggaran = r.id_anggaran AND r.status = 'APPROVED' 
    WHERE a.status = 'APPROVED' 
    GROUP BY a.id_anggaran, a.nama_kegiatan, a.jumlah_anggaran 
    ORDER BY a.id_anggaran DESC
");
$realtimeBudgets = $stmt->fetchAll();

// 3. Fetch latest approved realizations (transactions)
$stmt = $pdo->query("
    SELECT r.*, a.nama_kegiatan 
    FROM realisasi r 
    JOIN anggaran a ON r.id_anggaran = a.id_anggaran 
    WHERE r.status = 'APPROVED' 
    ORDER BY r.tanggal DESC, r.id_realisasi DESC 
    LIMIT 10
");
$realtimeTransactions = $stmt->fetchAll();


// --- DATA UNTUK TAB AUDITED ---
$search = $_GET['search'] ?? '';
$tahun = $_GET['tahun'] ?? '';

$query = "SELECT * FROM laporan WHERE status = 'AUDITED'";
$params = [];

if (!empty($search)) {
    $query .= " AND periode LIKE ?";
    $params[] = "%$search%";
}

if (!empty($tahun)) {
    $query .= " AND periode LIKE ?";
    $params[] = "%$tahun%";
}

$query .= " ORDER BY id_laporan DESC";

$stmt = $pdo->prepare($query);
$stmt->execute($params);
$laporans = $stmt->fetchAll();

// Ambil daftar tahun unik
$tahunStmt = $pdo->query("
    SELECT DISTINCT 
    RIGHT(periode, 4) as tahun 
    FROM laporan
    ORDER BY tahun DESC
");
$daftarTahun = $tahunStmt->fetchAll();

require_once '../includes/header.php';
?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-navy-900 mb-2">
                Laporan Keuangan Desa
            </h1>
            <p class="text-slate-600">
                Transparansi pengelolaan, penyerapan, dan laporan audit realisasi anggaran desa.
            </p>
        </div>
        
        <?php if ($tab === 'realtime'): ?>
            <div>
                <a href="export_realtime_pdf.php" target="_blank" class="bg-red-600 hover:bg-red-700 text-white px-5 py-2.5 rounded-lg font-medium inline-flex items-center gap-2 shadow-sm transition-colors hover-lift">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Cetak PDF Real-Time
                </a>
            </div>
        <?php endif; ?>
    </div>

    <!-- TABS NAV -->
    <div class="flex border-b border-slate-200 mb-8 overflow-x-auto whitespace-nowrap">
        <a href="?tab=realtime" class="py-4 px-6 font-semibold text-sm border-b-2 transition-all <?php echo $tab === 'realtime' ? 'border-primary text-primary' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300'; ?>">
            Dasbor Real-Time Transparansi
        </a>
        <a href="?tab=audited<?php echo !empty($search) ? '&search='.urlencode($search) : ''; ?><?php echo !empty($tahun) ? '&tahun='.urlencode($tahun) : ''; ?>" class="py-4 px-6 font-semibold text-sm border-b-2 transition-all <?php echo $tab === 'audited' ? 'border-primary text-primary' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300'; ?>">
            Arsip Laporan Audit Resmi (PDF)
        </a>
    </div>

    <!-- TAB CONTENT: REAL-TIME -->
    <?php if ($tab === 'realtime'): ?>
        
        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <div class="bg-white rounded-xl p-6 border border-slate-200 shadow-sm relative overflow-hidden hover-lift">
                <p class="text-sm font-medium text-slate-500 mb-1">Total Anggaran Disetujui</p>
                <h3 class="text-2xl font-bold text-navy-900 mb-2"><?php echo formatRupiah($totalAnggaranRealtime); ?></h3>
                <span class="inline-flex items-center text-xs font-medium text-slate-400">
                    Akumulasi Pagu Anggaran
                </span>
                <div class="absolute right-6 top-6 h-12 w-12 bg-blue-50 text-primary rounded-xl flex items-center justify-center">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </div>
            </div>
            
            <div class="bg-white rounded-xl p-6 border border-slate-200 shadow-sm relative overflow-hidden hover-lift">
                <p class="text-sm font-medium text-slate-500 mb-1">Total Dana Terealisasi</p>
                <h3 class="text-2xl font-bold text-green-600 mb-2"><?php echo formatRupiah($totalRealisasiRealtime); ?></h3>
                <div class="flex items-center justify-between text-xs font-semibold text-primary mb-1">
                    <span>Penyerapan</span>
                    <span><?php echo $totalAnggaranRealtime > 0 ? round(($totalRealisasiRealtime / $totalAnggaranRealtime) * 100, 1) : 0; ?>%</span>
                </div>
                <div class="w-full bg-slate-100 rounded-full h-1.5">
                    <div class="bg-primary h-1.5 rounded-full" style="width: <?php echo $totalAnggaranRealtime > 0 ? min(100, ($totalRealisasiRealtime / $totalAnggaranRealtime) * 100) : 0; ?>%"></div>
                </div>
                <div class="absolute right-6 top-6 h-12 w-12 bg-green-50 text-green-600 rounded-xl flex items-center justify-center">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>

            <div class="bg-white rounded-xl p-6 border border-slate-200 shadow-sm relative overflow-hidden hover-lift">
                <p class="text-sm font-medium text-slate-500 mb-1">Sisa Saldo Anggaran</p>
                <h3 class="text-2xl font-bold text-navy-900 mb-2"><?php echo formatRupiah($sisaAnggaranRealtime); ?></h3>
                <span class="inline-flex items-center text-xs font-medium text-slate-400">
                    Sisa pagu yang belum digunakan
                </span>
                <div class="absolute right-6 top-6 h-12 w-12 bg-slate-50 text-slate-600 rounded-xl flex items-center justify-center">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Detail Absorption Table -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden mb-10">
            <div class="p-6 border-b border-slate-200 bg-slate-50">
                <h3 class="text-lg font-bold text-navy-900">Rincian Penyerapan per Kegiatan</h3>
                <p class="text-xs text-slate-500">Anggaran yang telah disetujui beserta total realisasinya masing-masing</p>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase">Nama Kegiatan</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold text-slate-500 uppercase">Pagu Anggaran</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold text-slate-500 uppercase">Total Realisasi</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold text-slate-500 uppercase">Sisa Dana</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-slate-500 uppercase">Persentase Penyerapan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <?php if (count($realtimeBudgets) > 0): ?>
                            <?php foreach($realtimeBudgets as $row): 
                                $sisa = $row['jumlah_anggaran'] - $row['total_realisasi'];
                                $persen = $row['jumlah_anggaran'] > 0 ? ($row['total_realisasi'] / $row['jumlah_anggaran']) * 100 : 0;
                            ?>
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4 text-sm font-semibold text-navy-900">
                                    <?php echo htmlspecialchars($row['nama_kegiatan']); ?>
                                </td>
                                <td class="px-6 py-4 text-right text-sm text-slate-600">
                                    <?php echo formatRupiah($row['jumlah_anggaran']); ?>
                                </td>
                                <td class="px-6 py-4 text-right text-sm text-green-600 font-medium">
                                    <?php echo formatRupiah($row['total_realisasi']); ?>
                                </td>
                                <td class="px-6 py-4 text-right text-sm <?php echo $sisa < 0 ? 'text-red-500 font-semibold' : 'text-slate-600'; ?>">
                                    <?php echo formatRupiah($sisa); ?>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center">
                                        <div class="w-full bg-slate-100 rounded-full h-2 mr-2 max-w-[100px]">
                                            <div class="bg-primary h-2 rounded-full" style="width: <?php echo min(100, $persen); ?>%"></div>
                                        </div>
                                        <span class="text-xs font-semibold text-slate-600"><?php echo number_format($persen, 1); ?>%</span>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-slate-400">Belum ada anggaran disetujui (APPROVED).</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Transaction History -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-slate-200 bg-slate-50">
                <h3 class="text-lg font-bold text-navy-900">Riwayat Pengeluaran Dana Terkini</h3>
                <p class="text-xs text-slate-500">Daftar transaksi realisasi pengeluaran kas desa terbaru</p>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase">Tanggal</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase">Kegiatan Anggaran</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold text-slate-500 uppercase">Jumlah Realisasi</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-slate-500 uppercase">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <?php if (count($realtimeTransactions) > 0): ?>
                            <?php foreach($realtimeTransactions as $row): ?>
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4 text-sm text-slate-500 whitespace-nowrap">
                                    <?php echo date('d M Y', strtotime($row['tanggal'])); ?>
                                </td>
                                <td class="px-6 py-4 text-sm font-medium text-navy-900">
                                    <?php echo htmlspecialchars($row['nama_kegiatan']); ?>
                                </td>
                                <td class="px-6 py-4 text-right text-sm text-slate-700 font-semibold">
                                    <?php echo formatRupiah($row['jumlah_realisasi']); ?>
                                </td>
                                <td class="px-6 py-4 text-center whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-50 text-green-700 border border-green-100">
                                        <span class="h-1.5 w-1.5 bg-green-600 rounded-full mr-1.5"></span> APPROVED
                                    </span>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="px-6 py-10 text-center text-slate-400">Belum ada riwayat pengeluaran yang terdaftar.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    <!-- TAB CONTENT: AUDITED -->
    <?php else: ?>

        <!-- FILTER -->
        <form method="GET" class="bg-white p-4 rounded-xl shadow-sm border border-slate-200 mb-8 flex flex-wrap gap-4 items-center">
            <input type="hidden" name="tab" value="audited">

            <div class="flex-1 min-w-[200px]">
                <div class="relative">
                    <input 
                        type="text"
                        name="search"
                        value="<?php echo htmlspecialchars($search); ?>"
                        placeholder="Cari periode..."
                        class="block w-full px-4 py-2.5 border border-slate-300 rounded-lg text-sm"
                    >
                </div>
            </div>

            <div>
                <select 
                    name="tahun"
                    class="block w-full pl-3 pr-10 py-2.5 border border-slate-300 rounded-lg text-sm bg-white"
                >
                    <option value="">Semua Tahun</option>
                    <?php foreach($daftarTahun as $t): ?>
                        <option 
                            value="<?php echo $t['tahun']; ?>"
                            <?php if($tahun == $t['tahun']) echo 'selected'; ?>
                        >
                            <?php echo $t['tahun']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <button 
                type="submit"
                class="bg-navy-800 text-white px-5 py-2.5 rounded-lg text-sm hover:bg-navy-900 font-medium transition-colors"
            >
                Filter
            </button>

            <a 
                href="laporan.php?tab=audited"
                class="bg-slate-200 text-slate-700 px-5 py-2.5 rounded-lg text-sm hover:bg-slate-300 font-medium transition-colors"
            >
                Reset
            </a>
        </form>

        <!-- TABEL LAPORAN AUDITED -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase">Periode</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase">Total Anggaran</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase">Total Realisasi</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-slate-500 uppercase">Status</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold text-slate-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                    <?php if(count($laporans) > 0): ?>
                        <?php foreach($laporans as $row): ?>
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 text-sm font-semibold text-navy-900">
                                <?php echo htmlspecialchars($row['periode']); ?>
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-600 font-medium">
                                <?php echo formatRupiah($row['total_anggaran']); ?>
                            </td>
                            <td class="px-6 py-4 text-sm text-green-600 font-medium">
                                <?php echo formatRupiah($row['total_realisasi']); ?>
                            </td>
                            <td class="px-6 py-4 text-center whitespace-nowrap">
                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">
                                    <?php echo $row['status']; ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right whitespace-nowrap">
                                <a 
                                    href="export_pdf.php?id=<?php echo $row['id_laporan']; ?>"
                                    target="_blank"
                                    class="bg-red-100 text-red-700 hover:bg-red-200 px-4 py-2 rounded-lg inline-flex items-center gap-1 font-semibold text-xs transition-colors"
                                >
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    PDF
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center py-10 text-slate-500">
                                Data laporan tidak ditemukan.
                            </td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    <?php endif; ?>

</div>

<?php require_once '../includes/footer.php'; ?>