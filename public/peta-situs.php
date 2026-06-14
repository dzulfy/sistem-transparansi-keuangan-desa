<?php
require_once '../includes/header.php';
?>

<!-- Page Header -->
<div class="bg-white border-b border-cardBorder">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="text-center">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800 mb-3">
                <svg class="mr-1.5 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                </svg>
                Navigasi Portal
            </span>
            <h1 class="text-4xl font-extrabold text-navy-900 sm:text-5xl">Peta Situs</h1>
            <p class="mt-4 text-lg text-slate-500 max-w-2xl mx-auto">
                Temukan semua halaman dan fitur yang tersedia pada portal Sistem Transparansi Keuangan Desa Purwadana.
            </p>
        </div>
    </div>
</div>

<!-- Content -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">

        <!-- Halaman Publik -->
        <div class="bg-white rounded-2xl border border-cardBorder shadow-sm overflow-hidden hover-lift">
            <div class="bg-primary p-5">
                <div class="flex items-center gap-3">
                    <div class="h-10 w-10 bg-white/20 rounded-xl flex items-center justify-center">
                        <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-white font-bold text-base">Halaman Publik</h2>
                        <p class="text-blue-200 text-xs">Akses terbuka untuk semua masyarakat</p>
                    </div>
                </div>
            </div>
            <ul class="divide-y divide-slate-100">
                <li>
                    <a href="<?php echo $base_url; ?>/public/index.php" class="flex items-center justify-between px-5 py-3.5 hover:bg-secondary transition-colors group">
                        <div class="flex items-center gap-3">
                            <svg class="h-4 w-4 text-slate-400 group-hover:text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            <span class="text-sm font-medium text-slate-700 group-hover:text-primary">Beranda</span>
                        </div>
                        <svg class="h-4 w-4 text-slate-300 group-hover:text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </li>
                <li>
                    <a href="<?php echo $base_url; ?>/public/laporan.php" class="flex items-center justify-between px-5 py-3.5 hover:bg-secondary transition-colors group">
                        <div class="flex items-center gap-3">
                            <svg class="h-4 w-4 text-slate-400 group-hover:text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <span class="text-sm font-medium text-slate-700 group-hover:text-primary">Laporan Keuangan</span>
                        </div>
                        <svg class="h-4 w-4 text-slate-300 group-hover:text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </li>
                <li>
                    <a href="<?php echo $base_url; ?>/public/grafik.php" class="flex items-center justify-between px-5 py-3.5 hover:bg-secondary transition-colors group">
                        <div class="flex items-center gap-3">
                            <svg class="h-4 w-4 text-slate-400 group-hover:text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                            </svg>
                            <span class="text-sm font-medium text-slate-700 group-hover:text-primary">Visualisasi Grafik</span>
                        </div>
                        <svg class="h-4 w-4 text-slate-300 group-hover:text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </li>
                <li>
                    <a href="<?php echo $base_url; ?>/public/login.php" class="flex items-center justify-between px-5 py-3.5 hover:bg-secondary transition-colors group">
                        <div class="flex items-center gap-3">
                            <svg class="h-4 w-4 text-slate-400 group-hover:text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                            </svg>
                            <span class="text-sm font-medium text-slate-700 group-hover:text-primary">Login Petugas</span>
                        </div>
                        <svg class="h-4 w-4 text-slate-300 group-hover:text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Informasi & Bantuan -->
        <div class="bg-white rounded-2xl border border-cardBorder shadow-sm overflow-hidden hover-lift">
            <div class="bg-navy-800 p-5">
                <div class="flex items-center gap-3">
                    <div class="h-10 w-10 bg-white/20 rounded-xl flex items-center justify-center">
                        <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-white font-bold text-base">Informasi &amp; Bantuan</h2>
                        <p class="text-blue-200 text-xs">Dokumen resmi dan kontak</p>
                    </div>
                </div>
            </div>
            <ul class="divide-y divide-slate-100">
                <li>
                    <a href="<?php echo $base_url; ?>/public/kontak.php" class="flex items-center justify-between px-5 py-3.5 hover:bg-secondary transition-colors group">
                        <div class="flex items-center gap-3">
                            <svg class="h-4 w-4 text-slate-400 group-hover:text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <span class="text-sm font-medium text-slate-700 group-hover:text-primary">Kontak Kami</span>
                        </div>
                        <svg class="h-4 w-4 text-slate-300 group-hover:text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </li>
                <li>
                    <a href="<?php echo $base_url; ?>/public/syarat-ketentuan.php" class="flex items-center justify-between px-5 py-3.5 hover:bg-secondary transition-colors group">
                        <div class="flex items-center gap-3">
                            <svg class="h-4 w-4 text-slate-400 group-hover:text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <span class="text-sm font-medium text-slate-700 group-hover:text-primary">Syarat &amp; Ketentuan</span>
                        </div>
                        <svg class="h-4 w-4 text-slate-300 group-hover:text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </li>
                <li>
                    <a href="<?php echo $base_url; ?>/public/peta-situs.php" class="flex items-center justify-between px-5 py-3.5 hover:bg-secondary transition-colors group">
                        <div class="flex items-center gap-3">
                            <svg class="h-4 w-4 text-slate-400 group-hover:text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                            </svg>
                            <span class="text-sm font-medium text-slate-700 group-hover:text-primary">Peta Situs</span>
                        </div>
                        <svg class="h-4 w-4 text-slate-300 group-hover:text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Dashboard Petugas -->
        <div class="bg-white rounded-2xl border border-cardBorder shadow-sm overflow-hidden hover-lift">
            <div class="bg-slate-700 p-5">
                <div class="flex items-center gap-3">
                    <div class="h-10 w-10 bg-white/20 rounded-xl flex items-center justify-center">
                        <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-white font-bold text-base">Dashboard Petugas</h2>
                        <p class="text-slate-300 text-xs">Akses khusus login</p>
                    </div>
                </div>
            </div>
            <ul class="divide-y divide-slate-100">
                <?php
                $isLoggedIn = isset($_SESSION['user_id']);
                $role = $_SESSION['role'] ?? '';
                ?>
                <li>
                    <div class="flex items-center gap-3 px-5 py-3 bg-slate-50">
                        <svg class="h-4 w-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Admin</span>
                    </div>
                </li>
                <li>
                    <div class="flex items-center justify-between px-5 py-3.5 <?php echo ($isLoggedIn && $role === 'admin') ? 'hover:bg-secondary' : 'opacity-50'; ?> transition-colors group">
                        <div class="flex items-center gap-3">
                            <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z" />
                            </svg>
                            <span class="text-sm text-slate-600">Dashboard Admin</span>
                        </div>
                        <?php if ($isLoggedIn && $role === 'admin'): ?>
                            <a href="<?php echo $base_url; ?>/admin/index.php" class="text-xs text-primary font-medium hover:underline">Buka &rarr;</a>
                        <?php else: ?>
                            <span class="text-xs text-slate-400 flex items-center gap-1"><svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>Login</span>
                        <?php endif; ?>
                    </div>
                </li>
                <li>
                    <div class="flex items-center gap-3 px-5 py-3 bg-slate-50">
                        <svg class="h-4 w-4 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Bendahara</span>
                    </div>
                </li>
                <li>
                    <div class="flex items-center justify-between px-5 py-3.5 <?php echo ($isLoggedIn && $role === 'bendahara') ? 'hover:bg-secondary' : 'opacity-50'; ?> transition-colors group">
                        <div class="flex items-center gap-3">
                            <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z" />
                            </svg>
                            <span class="text-sm text-slate-600">Dashboard Bendahara</span>
                        </div>
                        <?php if ($isLoggedIn && $role === 'bendahara'): ?>
                            <a href="<?php echo $base_url; ?>/bendahara/index.php" class="text-xs text-primary font-medium hover:underline">Buka &rarr;</a>
                        <?php else: ?>
                            <span class="text-xs text-slate-400 flex items-center gap-1"><svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>Login</span>
                        <?php endif; ?>
                    </div>
                </li>
                <li>
                    <div class="flex items-center gap-3 px-5 py-3 bg-slate-50">
                        <svg class="h-4 w-4 text-navy-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Kepala Desa</span>
                    </div>
                </li>
                <li>
                    <div class="flex items-center justify-between px-5 py-3.5 <?php echo ($isLoggedIn && $role === 'kepala_desa') ? 'hover:bg-secondary' : 'opacity-50'; ?> transition-colors group">
                        <div class="flex items-center gap-3">
                            <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z" />
                            </svg>
                            <span class="text-sm text-slate-600">Dashboard Kepala Desa</span>
                        </div>
                        <?php if ($isLoggedIn && $role === 'kepala_desa'): ?>
                            <a href="<?php echo $base_url; ?>/kepala_desa/index.php" class="text-xs text-primary font-medium hover:underline">Buka &rarr;</a>
                        <?php else: ?>
                            <span class="text-xs text-slate-400 flex items-center gap-1"><svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>Login</span>
                        <?php endif; ?>
                    </div>
                </li>
            </ul>
        </div>

    </div>

    <!-- Struktur Visual -->
    <div class="mt-12 bg-white rounded-2xl border border-cardBorder shadow-sm p-8">
        <h2 class="text-lg font-bold text-navy-900 mb-6 flex items-center gap-2">
            <svg class="h-5 w-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
            </svg>
            Struktur Portal STKD Desa Purwadana
        </h2>
        <div class="overflow-x-auto">
            <div class="min-w-max">
                <!-- Root -->
                <div class="flex flex-col items-center">
                    <div class="bg-primary text-white px-5 py-2.5 rounded-xl text-sm font-bold shadow">STKD Desa Purwadana</div>
                    <div class="w-px h-6 bg-slate-300"></div>
                    <!-- Level 1 -->
                    <div class="flex gap-12 items-start">
                        <!-- Publik Branch -->
                        <div class="flex flex-col items-center">
                            <div class="w-px h-6 bg-slate-300"></div>
                            <div class="bg-blue-100 text-primary border border-cardBorder px-4 py-2 rounded-lg text-sm font-semibold">Publik</div>
                            <div class="w-px h-6 bg-slate-300"></div>
                            <div class="flex gap-6 items-start">
                                <div class="flex flex-col items-center">
                                    <div class="w-px h-6 bg-slate-300"></div>
                                    <div class="bg-slate-50 border border-slate-200 px-3 py-1.5 rounded-lg text-xs text-slate-600">Beranda</div>
                                </div>
                                <div class="flex flex-col items-center">
                                    <div class="w-px h-6 bg-slate-300"></div>
                                    <div class="bg-slate-50 border border-slate-200 px-3 py-1.5 rounded-lg text-xs text-slate-600">Laporan</div>
                                </div>
                                <div class="flex flex-col items-center">
                                    <div class="w-px h-6 bg-slate-300"></div>
                                    <div class="bg-slate-50 border border-slate-200 px-3 py-1.5 rounded-lg text-xs text-slate-600">Grafik</div>
                                </div>
                                <div class="flex flex-col items-center">
                                    <div class="w-px h-6 bg-slate-300"></div>
                                    <div class="bg-slate-50 border border-slate-200 px-3 py-1.5 rounded-lg text-xs text-slate-600">Kontak</div>
                                </div>
                            </div>
                        </div>
                        <!-- Admin Branch -->
                        <div class="flex flex-col items-center">
                            <div class="w-px h-6 bg-slate-300"></div>
                            <div class="bg-blue-100 text-primary border border-cardBorder px-4 py-2 rounded-lg text-sm font-semibold">Admin</div>
                            <div class="w-px h-6 bg-slate-300"></div>
                            <div class="flex gap-6 items-start">
                                <div class="flex flex-col items-center">
                                    <div class="w-px h-6 bg-slate-300"></div>
                                    <div class="bg-slate-50 border border-slate-200 px-3 py-1.5 rounded-lg text-xs text-slate-600">Dashboard</div>
                                </div>
                                <div class="flex flex-col items-center">
                                    <div class="w-px h-6 bg-slate-300"></div>
                                    <div class="bg-slate-50 border border-slate-200 px-3 py-1.5 rounded-lg text-xs text-slate-600">Kelola User</div>
                                </div>
                                <div class="flex flex-col items-center">
                                    <div class="w-px h-6 bg-slate-300"></div>
                                    <div class="bg-slate-50 border border-slate-200 px-3 py-1.5 rounded-lg text-xs text-slate-600">Log Aktivitas</div>
                                </div>
                            </div>
                        </div>
                        <!-- Bendahara Branch -->
                        <div class="flex flex-col items-center">
                            <div class="w-px h-6 bg-slate-300"></div>
                            <div class="bg-green-100 text-green-700 border border-green-200 px-4 py-2 rounded-lg text-sm font-semibold">Bendahara</div>
                            <div class="w-px h-6 bg-slate-300"></div>
                            <div class="flex gap-6 items-start">
                                <div class="flex flex-col items-center">
                                    <div class="w-px h-6 bg-slate-300"></div>
                                    <div class="bg-slate-50 border border-slate-200 px-3 py-1.5 rounded-lg text-xs text-slate-600">Dashboard</div>
                                </div>
                                <div class="flex flex-col items-center">
                                    <div class="w-px h-6 bg-slate-300"></div>
                                    <div class="bg-slate-50 border border-slate-200 px-3 py-1.5 rounded-lg text-xs text-slate-600">Realisasi</div>
                                </div>
                            </div>
                        </div>
                        <!-- Kepala Desa Branch -->
                        <div class="flex flex-col items-center">
                            <div class="w-px h-6 bg-slate-300"></div>
                            <div class="bg-navy-800 text-white px-4 py-2 rounded-lg text-sm font-semibold">Kepala Desa</div>
                            <div class="w-px h-6 bg-slate-300"></div>
                            <div class="flex gap-6 items-start">
                                <div class="flex flex-col items-center">
                                    <div class="w-px h-6 bg-slate-300"></div>
                                    <div class="bg-slate-50 border border-slate-200 px-3 py-1.5 rounded-lg text-xs text-slate-600">Dashboard</div>
                                </div>
                                <div class="flex flex-col items-center">
                                    <div class="w-px h-6 bg-slate-300"></div>
                                    <div class="bg-slate-50 border border-slate-200 px-3 py-1.5 rounded-lg text-xs text-slate-600">Validasi</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>
