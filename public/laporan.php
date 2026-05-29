<?php
require_once '../config/database.php';
require_once '../includes/functions.php';

$search = $_GET['search'] ?? '';
$tahun = $_GET['tahun'] ?? '';

$query = "SELECT * FROM laporan WHERE status = 'AUDITED'";
$params = [];

// Filter pencarian
if (!empty($search)) {
    $query .= " AND periode LIKE ?";
    $params[] = "%$search%";
}

// Filter tahun
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

    <div class="mb-8">
        <h1 class="text-3xl font-bold text-navy-900 mb-2">
            Laporan Keuangan Desa
        </h1>

        <p class="text-slate-600">
            Telusuri laporan realisasi anggaran per semester yang telah diaudit.
        </p>
    </div>

    <!-- FILTER -->
    <form method="GET" class="bg-white p-4 rounded-xl shadow-sm border border-slate-200 mb-8 flex flex-wrap gap-4 items-center">

        <div class="flex-1 min-w-[200px]">
            <div class="relative">
                <input 
                    type="text"
                    name="search"
                    value="<?php echo htmlspecialchars($search); ?>"
                    placeholder="Cari periode..."
                    class="block w-full pl-4 pr-3 py-2 border border-slate-300 rounded-lg"
                >
            </div>
        </div>

        <div>
            <select 
                name="tahun"
                class="block w-full pl-3 pr-10 py-2 border border-slate-300 rounded-lg"
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
            class="bg-navy-800 text-white px-5 py-2 rounded-lg"
        >
            Filter
        </button>

        <a 
            href="laporan.php"
            class="bg-slate-200 text-slate-700 px-5 py-2 rounded-lg"
        >
            Reset
        </a>

    </form>

    <!-- TABEL -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">

        <div class="overflow-x-auto">

            <table class="min-w-full divide-y divide-slate-200">

                <thead class="bg-slate-50">

                    <tr>
                        <th class="px-6 py-4 text-left">Periode</th>
                        <th class="px-6 py-4 text-left">Total Anggaran</th>
                        <th class="px-6 py-4 text-left">Total Realisasi</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>

                </thead>

                <tbody>

                <?php if(count($laporans) > 0): ?>

                    <?php foreach($laporans as $row): ?>

                    <tr class="border-b">

                        <td class="px-6 py-4">
                            <?php echo htmlspecialchars($row['periode']); ?>
                        </td>

                        <td class="px-6 py-4">
                            <?php echo formatRupiah($row['total_anggaran']); ?>
                        </td>

                        <td class="px-6 py-4">
                            <?php echo formatRupiah($row['total_realisasi']); ?>
                        </td>

                        <td class="px-6 py-4 text-center">

                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs">
                                <?php echo $row['status']; ?>
                            </span>

                        </td>

                        <td class="px-6 py-4 text-right">

                            <a 
                                href="export_pdf.php?id=<?php echo $row['id_laporan']; ?>"
                                target="_blank"
                                class="bg-red-100 text-red-700 px-4 py-2 rounded-lg inline-flex items-center gap-1"
                            >
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

</div>

<?php require_once '../includes/footer.php'; ?>