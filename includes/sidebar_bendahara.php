<?php
// includes/sidebar_bendahara.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$base_url = '/rpl';
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Bendahara - STKD</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        navy: { 800: '#1e3a5f', 900: '#0f172a' },
                        primary: '#2563eb',
                        secondary: '#f0f4ff',
                    }
                }
            }
        }
    </script>
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-slate-50 font-sans text-slate-800 antialiased flex h-screen overflow-hidden">

<aside class="w-64 bg-white border-r border-slate-200 flex flex-col flex-shrink-0">
    <div class="p-6 border-b border-slate-200">
        <div class="flex items-center gap-3">
            <div class="h-10 w-10 bg-primary text-white rounded-lg flex items-center justify-center">
                <i data-lucide="building-2" class="h-6 w-6"></i>
            </div>
            <div>
                <h1 class="text-base font-bold text-navy-800 leading-tight">Bendahara Desa</h1>
                <p class="text-xs text-slate-500">Desa Maju Jaya</p>
            </div>
        </div>
    </div>
    
    <div class="flex-1 overflow-y-auto py-4">
        <nav class="px-3 space-y-1">
            <a href="index.php" class="<?php echo $current_page == 'index.php' ? 'bg-slate-100 text-primary font-semibold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900'; ?> group flex items-center px-3 py-2.5 text-sm rounded-lg transition-colors">
                <i data-lucide="layout-dashboard" class="<?php echo $current_page == 'index.php' ? 'text-primary' : 'text-slate-400 group-hover:text-slate-500'; ?> mr-3 flex-shrink-0 h-5 w-5"></i>
                Dasbor
            </a>
            <a href="input_anggaran.php" class="<?php echo $current_page == 'input_anggaran.php' ? 'bg-slate-100 text-primary font-semibold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900'; ?> group flex items-center px-3 py-2.5 text-sm rounded-lg transition-colors">
                <i data-lucide="file-plus-2" class="<?php echo $current_page == 'input_anggaran.php' ? 'text-primary' : 'text-slate-400 group-hover:text-slate-500'; ?> mr-3 flex-shrink-0 h-5 w-5"></i>
                Input Anggaran
            </a>
            <a href="daftar_anggaran.php" class="<?php echo $current_page == 'daftar_anggaran.php' ? 'bg-slate-100 text-primary font-semibold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900'; ?> group flex items-center px-3 py-2.5 text-sm rounded-lg transition-colors">
                <i data-lucide="list-todo" class="<?php echo $current_page == 'daftar_anggaran.php' ? 'text-primary' : 'text-slate-400 group-hover:text-slate-500'; ?> mr-3 flex-shrink-0 h-5 w-5"></i>
                Daftar Anggaran
            </a>
            <a href="input_realisasi.php" class="<?php echo $current_page == 'input_realisasi.php' ? 'bg-slate-100 text-primary font-semibold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900'; ?> group flex items-center px-3 py-2.5 text-sm rounded-lg transition-colors">
                <i data-lucide="file-edit" class="<?php echo $current_page == 'input_realisasi.php' ? 'text-primary' : 'text-slate-400 group-hover:text-slate-500'; ?> mr-3 flex-shrink-0 h-5 w-5"></i>
                Input Realisasi
            </a>
            <a href="daftar_realisasi.php" class="<?php echo $current_page == 'daftar_realisasi.php' ? 'bg-slate-100 text-primary font-semibold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900'; ?> group flex items-center px-3 py-2.5 text-sm rounded-lg transition-colors">
                <i data-lucide="list" class="<?php echo $current_page == 'daftar_realisasi.php' ? 'text-primary' : 'text-slate-400 group-hover:text-slate-500'; ?> mr-3 flex-shrink-0 h-5 w-5"></i>
                Daftar Realisasi
            </a>
        </nav>
    </div>
    
    <div class="p-4 border-t border-slate-200">
        <a href="<?php echo $base_url; ?>/logout.php" class="group flex items-center px-3 py-2 text-sm font-medium text-slate-600 hover:text-red-600 transition-colors">
            <i data-lucide="log-out" class="text-slate-400 group-hover:text-red-500 mr-3 flex-shrink-0 h-5 w-5"></i>
            Keluar
        </a>
    </div>
</aside>

<main class="flex-1 flex flex-col overflow-hidden">
    <!-- Topbar for Bendahara -->
    <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-6 sm:px-8">
        <h2 class="text-xl font-semibold text-primary">Sistem Keuangan Desa</h2>
        <div class="flex items-center gap-4">
            <div class="relative hidden sm:block">
                <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400"></i>
                <input type="text" placeholder="Cari data..." class="pl-9 pr-4 py-2 bg-slate-100 border-transparent rounded-full text-sm focus:bg-white focus:ring-2 focus:ring-primary focus:border-transparent transition-all outline-none w-64">
            </div>
            <button class="p-2 text-slate-400 hover:text-slate-600"><i data-lucide="bell" class="h-5 w-5"></i></button>
            <button class="p-2 text-slate-400 hover:text-slate-600"><i data-lucide="settings" class="h-5 w-5"></i></button>
            <div class="h-8 w-px bg-slate-200 mx-2"></div>
            <div class="flex items-center gap-2">
                <div class="text-right hidden sm:block">
                    <p class="text-sm font-semibold text-slate-700 leading-tight"><?php echo htmlspecialchars($_SESSION['nama'] ?? 'Bendahara'); ?></p>
                    <p class="text-[10px] text-slate-500 uppercase tracking-wider">Administrator</p>
                </div>
                <div class="h-9 w-9 rounded-full bg-slate-200 overflow-hidden border border-slate-200">
                    <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($_SESSION['nama'] ?? 'B'); ?>&background=random" alt="Avatar" class="h-full w-full object-cover">
                </div>
            </div>
        </div>
    </header>
    
    <div class="flex-1 overflow-y-auto p-6 md:p-8">
