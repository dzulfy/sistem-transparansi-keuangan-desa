<?php
require_once 'config/database.php';
require_once 'includes/functions.php';

// Calculate totals for summary cards
$stmtAnggaran = $pdo->query("SELECT SUM(jumlah_anggaran) as total FROM anggaran WHERE status = 'APPROVED'");
$totalAnggaran = $stmtAnggaran->fetch()['total'] ?? 0;

$stmtRealisasi = $pdo->query("SELECT SUM(jumlah_realisasi) as total FROM realisasi WHERE status = 'APPROVED'");
$totalRealisasi = $stmtRealisasi->fetch()['total'] ?? 0;

$persentase = $totalAnggaran > 0 ? round(($totalRealisasi / $totalAnggaran) * 100, 1) : 0;

// Calculate active year
$stmtYear = $pdo->query("SELECT MAX(YEAR(tanggal)) as max_year FROM anggaran WHERE status = 'APPROVED'");
$activeYear = $stmtYear->fetch()['max_year'];
if (!$activeYear) {
    $activeYear = date('Y');
}

// Monthly labels
$months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agt', 'Sep', 'Okt', 'Nov', 'Des'];
$anggaranBulanan = array_fill(1, 12, 0);
$realisasiBulanan = array_fill(1, 12, 0);

// Get monthly budgets
$stmt = $pdo->prepare("
    SELECT MONTH(tanggal) as bulan, SUM(jumlah_anggaran) as total 
    FROM anggaran 
    WHERE status = 'APPROVED' AND YEAR(tanggal) = ? 
    GROUP BY MONTH(tanggal)
");
$stmt->execute([$activeYear]);
while ($row = $stmt->fetch()) {
    $anggaranBulanan[(int)$row['bulan']] = (float)$row['total'];
}

// Get monthly realizations
$stmt = $pdo->prepare("
    SELECT MONTH(tanggal) as bulan, SUM(jumlah_realisasi) as total 
    FROM realisasi 
    WHERE status = 'APPROVED' AND YEAR(tanggal) = ? 
    GROUP BY MONTH(tanggal)
");
$stmt->execute([$activeYear]);
while ($row = $stmt->fetch()) {
    $realisasiBulanan[(int)$row['bulan']] = (float)$row['total'];
}

// Helper categorizer
if (!function_exists('dapatkanKategori')) {
    function dapatkanKategori($nama_kegiatan) {
        $nama = strtolower($nama_kegiatan);
        if (strpos($nama, 'jembatan') !== false || strpos($nama, 'jalan') !== false || strpos($nama, 'kantor') !== false || strpos($nama, 'bangun') !== false || strpos($nama, 'renovasi') !== false || strpos($nama, 'infrastruktur') !== false || strpos($nama, 'gedung') !== false || strpos($nama, 'saluran') !== false || strpos($nama, 'drainase') !== false) {
            return 'Infrastruktur';
        } elseif (strpos($nama, 'sehat') !== false || strpos($nama, 'kesehatan') !== false || strpos($nama, 'posyandu') !== false || strpos($nama, 'obat') !== false || strpos($nama, 'puskesmas') !== false || strpos($nama, 'gizi') !== false || strpos($nama, 'stunting') !== false) {
            return 'Kesehatan';
        } elseif (strpos($nama, 'sekolah') !== false || strpos($nama, 'pendidikan') !== false || strpos($nama, 'guru') !== false || strpos($nama, 'paud') !== false || strpos($nama, 'buku') !== false || strpos($nama, 'perpustakaan') !== false || strpos($nama, 'pelatihan') !== false) {
            return 'Pendidikan';
        } else {
            return 'Pemberdayaan'; // Default fallback
        }
    }
}

// Realization per category
$stmtRealisasiKategori = $pdo->query("
    SELECT r.jumlah_realisasi, a.nama_kegiatan 
    FROM realisasi r 
    JOIN anggaran a ON r.id_anggaran = a.id_anggaran 
    WHERE r.status = 'APPROVED'
");
$realisasiKategoriList = $stmtRealisasiKategori->fetchAll();

$kategoriTotals = [
    'Infrastruktur' => 0,
    'Pemberdayaan' => 0,
    'Kesehatan' => 0,
    'Pendidikan' => 0
];

foreach ($realisasiKategoriList as $row) {
    $kategori = dapatkanKategori($row['nama_kegiatan']);
    $kategoriTotals[$kategori] += (float)$row['jumlah_realisasi'];
}

require_once 'includes/header.php';
?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-navy-900 mb-2">Grafik & Statistik</h1>
        <p class="text-slate-600">Visualisasi data keuangan desa untuk memudahkan pemantauan dan evaluasi.</p>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-xl p-6 border border-slate-200 shadow-sm hover-lift">
            <p class="text-sm font-medium text-slate-500 uppercase tracking-wide mb-1">Total Anggaran (Tahun Ini)</p>
            <h3 class="text-2xl font-bold text-navy-900 mb-2"><?php echo formatRupiah($totalAnggaran); ?></h3>
        </div>
        <div class="bg-white rounded-xl p-6 border border-slate-200 shadow-sm hover-lift">
            <p class="text-sm font-medium text-slate-500 uppercase tracking-wide mb-1">Total Realisasi</p>
            <h3 class="text-2xl font-bold text-green-600 mb-2"><?php echo formatRupiah($totalRealisasi); ?></h3>
        </div>
        <div class="bg-white rounded-xl p-6 border border-slate-200 shadow-sm hover-lift">
            <p class="text-sm font-medium text-slate-500 uppercase tracking-wide mb-1">Persentase Realisasi</p>
            <h3 class="text-2xl font-bold text-primary mb-2"><?php echo $persentase; ?>%</h3>
            <div class="w-full bg-slate-200 rounded-full h-2">
                <div class="bg-primary h-2 rounded-full" style="width: <?php echo $persentase; ?>%"></div>
            </div>
        </div>
    </div>

    <!-- Charts -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Bar Chart -->
        <div class="bg-white rounded-xl p-6 border border-slate-200 shadow-sm">
            <h3 class="text-lg font-bold text-navy-900 mb-4">Anggaran vs Realisasi (Per Bulan)</h3>
            <div class="h-72">
                <canvas id="barChart"></canvas>
            </div>
        </div>
        <!-- Donut Chart -->
        <div class="bg-white rounded-xl p-6 border border-slate-200 shadow-sm">
            <h3 class="text-lg font-bold text-navy-900 mb-4">Realisasi Per Kategori</h3>
            <div class="h-72 flex justify-center">
                <canvas id="donutChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script>
    // Initialize Charts
    const barCtx = document.getElementById('barChart').getContext('2d');
    new Chart(barCtx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($months); ?>,
            datasets: [
                {
                    label: 'Anggaran',
                    data: <?php echo json_encode(array_values($anggaranBulanan)); ?>,
                    backgroundColor: '#1e3a5f',
                    borderRadius: 4
                },
                {
                    label: 'Realisasi',
                    data: <?php echo json_encode(array_values($realisasiBulanan)); ?>,
                    backgroundColor: '#2563eb',
                    borderRadius: 4
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom' }
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });

    const donutCtx = document.getElementById('donutChart').getContext('2d');
    new Chart(donutCtx, {
        type: 'doughnut',
        data: {
            labels: ['Infrastruktur', 'Pemberdayaan', 'Kesehatan', 'Pendidikan'],
            datasets: [{
                data: [
                    <?php echo $kategoriTotals['Infrastruktur']; ?>,
                    <?php echo $kategoriTotals['Pemberdayaan']; ?>,
                    <?php echo $kategoriTotals['Kesehatan']; ?>,
                    <?php echo $kategoriTotals['Pendidikan']; ?>
                ],
                backgroundColor: ['#1e3a5f', '#2563eb', '#3b82f6', '#93c5fd'],
                borderWidth: 0,
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'right' }
            },
            cutout: '70%'
        }
    });
</script>

<?php require_once 'includes/footer.php'; ?>
