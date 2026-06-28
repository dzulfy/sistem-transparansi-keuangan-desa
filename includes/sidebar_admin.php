<?php
// includes/sidebar_admin.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$base_url = 'https://desapurwadana.my.id';
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Administrasi - STKD</title>
    <link rel="icon" href="<?php echo $base_url; ?>/assets/img/logo-desa.PNG" type="image/png">
    
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
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-secondary font-sans text-slate-800 antialiased flex h-screen overflow-hidden">

<!-- Sidebar -->
<aside class="w-64 bg-white border-r border-slate-200 flex flex-col flex-shrink-0">
    <div class="h-16 flex items-center px-6 border-b border-slate-200">
        <div class="flex items-center gap-4">
            <img src="../assets/img/logo-desa.PNG" alt="Logo Desa Purwadana" class="h-10 w-auto group-hover:scale-110 transition-transform object-contain">
            <div>
                        <span class="block text-xs text-slate-500 font-medium leading-none">Transparansi Keuangan</span>
                        <span class="block text-lg font-bold text-navy-800 leading-tight">Desa Purwadana</span>
                    </div>
        </div>
    </div>
    
    <div class="flex-1 overflow-y-auto py-4">
        <nav class="px-3 space-y-1">
            <a href="index.php" class="<?php echo $current_page == 'index.php' ? 'bg-primary text-white' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900'; ?> group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors">
                <i data-lucide="layout-dashboard" class="<?php echo $current_page == 'index.php' ? 'text-white' : 'text-slate-400 group-hover:text-slate-500'; ?> mr-3 flex-shrink-0 h-5 w-5"></i>
                Dasbor
            </a>
            <a href="kelola_user.php" class="<?php echo $current_page == 'kelola_user.php' ? 'bg-primary text-white' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900'; ?> group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors">
                <i data-lucide="users" class="<?php echo $current_page == 'kelola_user.php' ? 'text-white' : 'text-slate-400 group-hover:text-slate-500'; ?> mr-3 flex-shrink-0 h-5 w-5"></i>
                Kelola User
            </a>

            <a href="log_aktivitas.php" class="<?php echo $current_page == 'log_aktivitas.php' ? 'bg-primary text-white' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900'; ?> group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors">
                <i data-lucide="history" class="<?php echo $current_page == 'log_aktivitas.php' ? 'text-white' : 'text-slate-400 group-hover:text-slate-500'; ?> mr-3 flex-shrink-0 h-5 w-5"></i>
                Log Aktivitas
            </a>
        </nav>
    </div>
    
    <div class="p-4 border-t border-slate-200">
        <div class="flex items-center gap-3 px-3 py-2 rounded-lg bg-slate-50">
            <div class="h-8 w-8 rounded-full bg-navy-800 text-white flex items-center justify-center font-bold text-xs">
                <?php echo strtoupper(substr($_SESSION['nama'] ?? 'A', 0, 1)); ?>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-slate-900 truncate"><?php echo htmlspecialchars($_SESSION['nama'] ?? 'Administrator'); ?></p>
                <p class="text-xs text-slate-500 truncate">Administrator</p>
            </div>
        </div>
        <a href="<?php echo $base_url; ?>/logout.php" class="mt-2 group flex items-center px-3 py-2 text-sm font-medium text-red-600 hover:bg-red-50 rounded-lg transition-colors">
            <i data-lucide="log-out" class="text-red-400 group-hover:text-red-500 mr-3 flex-shrink-0 h-4 w-4"></i>
            Keluar
        </a>
    </div>
</aside>

<!-- Main Content wrapper -->
<main class="flex-1 flex flex-col overflow-hidden bg-slate-50/50">
    <div class="flex-1 overflow-y-auto p-6 md:p-8">
