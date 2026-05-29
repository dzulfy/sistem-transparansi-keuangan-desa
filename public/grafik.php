<?php
require_once '../config/database.php';
require_once '../includes/functions.php';

// Calculate totals for summary cards
$stmtAnggaran = $pdo->query("SELECT SUM(jumlah_anggaran) as total FROM anggaran WHERE status = 'APPROVED'");
$totalAnggaran = $stmtAnggaran->fetch()['total'] ?? 0;

$stmtRealisasi = $pdo->query("SELECT SUM(jumlah_realisasi) as total FROM realisasi WHERE status = 'APPROVED'");
$totalRealisasi = $stmtRealisasi->fetch()['total'] ?? 0;

$persentase = $totalAnggaran > 0 ? round(($totalRealisasi / $totalAnggaran) * 100, 1) : 0;

require_once '../includes/header.php';
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
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
            datasets: [
                {
                    label: 'Anggaran',
                    data: [150, 200, 180, 220, 250, 300], // Mockup data in millions
                    backgroundColor: '#1e3a5f',
                    borderRadius: 4
                },
                {
                    label: 'Realisasi',
                    data: [120, 180, 150, 210, 190, 200], // Mockup data in millions
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
                data: [45, 25, 15, 15],
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

<?php require_once '../includes/footer.php'; ?>
