<?php
require_once 'includes/header.php';
?>

<!-- Hero Section -->
<div class="relative bg-white overflow-hidden">
    <div class="max-w-7xl mx-auto">
        <div class="relative z-10 pb-8 bg-white sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32 pt-10 sm:pt-16 lg:pt-20">
            <main class="mt-10 mx-auto max-w-7xl px-4 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 lg:px-8 xl:mt-28">
                <div class="sm:text-center lg:text-left">
                    
                    <h1 class="text-4xl tracking-tight font-extrabold text-navy-900 sm:text-5xl md:text-6xl">
                        <span class="block">Transparansi Keuangan</span>
                        <span class="block text-primary">Desa Purwadana</span>
                    </h1>
                    <p class="mt-3 text-base text-slate-500 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
                        Pantau pengelolaan dana desa secara real-time. Kami berkomitmen untuk menyajikan informasi keuangan yang transparan, akurat, dan mudah diakses oleh seluruh lapisan masyarakat.
                    </p>
                    <div class="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-start">
                        <div class="rounded-md shadow">
                            <a href="<?php echo $base_url; ?>/login.php" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-lg text-white bg-primary hover:bg-blue-700 md:py-4 md:text-lg md:px-10 transition-colors hover-lift">
                                Login Petugas Desa
                            </a>
                        </div>
                        <div class="mt-3 sm:mt-0 sm:ml-3">
                            <a href="<?php echo $base_url; ?>/laporan.php" class="w-full flex items-center justify-center px-8 py-3 border-2 border-slate-200 text-base font-medium rounded-lg text-slate-700 bg-white hover:bg-slate-50 md:py-4 md:text-lg md:px-10 transition-colors hover-lift">
                                Eksplorasi Data Publik
                            </a>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <!-- Hero Image Placeholder (Abstract Pattern) -->
    <div class="lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2 bg-slate-50 flex items-center justify-center border-l border-slate-100">
    <img src="assets/img/kantor-desa.jpg" alt="Kantor Desa Purwadana" class="w-full h-full object-cover">
    </div>
</div>

<!-- Features Section -->
<div class="py-16 bg-secondary">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-base text-primary font-semibold tracking-wide uppercase">Fitur Publik</h2>
            <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-navy-900 sm:text-4xl">Akses Terbuka untuk Masyarakat</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="bg-white rounded-2xl p-8 shadow-sm border border-cardBorder hover-lift">
                <div class="h-12 w-12 bg-blue-100 text-primary rounded-xl flex items-center justify-center mb-6">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-navy-800 mb-3">Laporan Detail</h3>
                <p class="text-slate-600 mb-4">Akses dokumen laporan realisasi anggaran per semester secara mendetail. Dokumen dapat diunduh dalam format PDF.</p>
                <a href="<?php echo $base_url; ?>/laporan.php" class="text-primary font-semibold hover:underline">Lihat Laporan &rarr;</a>
            </div>
            
            <div class="bg-white rounded-2xl p-8 shadow-sm border border-cardBorder hover-lift">
                <div class="h-12 w-12 bg-green-100 text-green-600 rounded-xl flex items-center justify-center mb-6">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-navy-800 mb-3">Visualisasi Grafik</h3>
                <p class="text-slate-600 mb-4">Pantau tren dan komposisi pengeluaran desa melalui grafik interaktif yang mudah dipahami oleh siapa saja.</p>
                <a href="<?php echo $base_url; ?>/grafik.php" class="text-primary font-semibold hover:underline">Lihat Grafik &rarr;</a>
            </div>
        </div>
    </div>
</div>

<!-- CTA Section -->
<div class="bg-navy-800">
    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:py-16 lg:px-8 lg:flex lg:items-center lg:justify-between">
        <h2 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl">
            <span class="block">Siap Membangun Desa Lebih Transparan?</span>
            <span class="block text-blue-300">Mari awasi bersama dana pembangunan desa.</span>
        </h2>
        <div class="mt-8 flex lg:mt-0 lg:flex-shrink-0 gap-4">
            <div class="inline-flex rounded-md shadow">
                <span class="inline-flex items-center px-4 py-2 border border-transparent text-base font-medium rounded-md text-navy-900 bg-white hover:bg-slate-50">
                    <svg class="mr-2 h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                    Audit Terstandar
                </span>
            </div>
            <div class="inline-flex rounded-md shadow">
                <span class="inline-flex items-center px-4 py-2 border border-transparent text-base font-medium rounded-md text-navy-900 bg-white hover:bg-slate-50">
                    <svg class="mr-2 h-5 w-5 text-primary" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" /></svg>
                    Akses 24/7
                </span>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
