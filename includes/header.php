<?php
// includes/header.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// determine base path dynamically or use a constant
$base_url = '/rpl'; 
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Transparansi Keuangan Desa</title>
    
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- TailwindCSS v3 via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Tailwind Config for Custom Colors -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        navy: {
                            800: '#1e3a5f',
                            900: '#0f172a',
                        },
                        primary: '#2563eb', // Royal Blue
                        secondary: '#f0f4ff', // Light Blue Background
                        cardBorder: '#dbeafe',
                    }
                }
            }
        }
    </script>

    <!-- Custom Micro-animations -->
    <style>
        .hover-lift {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .hover-lift:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
    </style>
    
    <!-- Chart.js (Loaded only if needed) -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-secondary font-sans text-slate-800 antialiased flex flex-col min-h-screen">

<!-- Navbar -->
<nav class="bg-white border-b border-cardBorder sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <a href="<?php echo $base_url; ?>/public/index.php" class="flex-shrink-0 flex items-center gap-2 group">
                    
                    <!-- REPLACEMENT: Tag SVG lama diganti dengan tag IMG di bawah ini -->
                    <img src="../assets/img/logo-desa.PNG" alt="Logo Desa Purwadana" class="h-10 w-auto group-hover:scale-110 transition-transform object-contain">
                    
                    <div>
                        <span class="block text-xs text-slate-500 font-medium leading-none">Transparansi Keuangan</span>
                        <span class="block text-lg font-bold text-navy-800 leading-tight">Desa Purwadana</span>
                    </div>
                </a>
            </div>
            <div class="hidden sm:ml-6 sm:flex sm:items-center sm:space-x-8">
                <a href="<?php echo $base_url; ?>/public/laporan.php" class="text-slate-600 hover:text-primary font-medium transition-colors">Lihat Laporan</a>
                <a href="<?php echo $base_url; ?>/public/grafik.php" class="text-slate-600 hover:text-primary font-medium transition-colors">Lihat Grafik</a>
                
                <?php if(isset($_SESSION['user_id'])): ?>
                    <?php 
                        $dashboard_url = '#';
                        if($_SESSION['role'] == 'admin') $dashboard_url = $base_url.'/admin/index.php';
                        elseif($_SESSION['role'] == 'bendahara') $dashboard_url = $base_url.'/bendahara/index.php';
                        elseif($_SESSION['role'] == 'kepala_desa') $dashboard_url = $base_url.'/kepala_desa/index.php';
                    ?>
                    <a href="<?php echo $dashboard_url; ?>" class="bg-navy-800 text-white px-5 py-2 rounded-lg font-medium hover:bg-navy-900 transition-colors hover-lift">Dashboard</a>
                <?php else: ?>
                    <a href="<?php echo $base_url; ?>/public/login.php" class="bg-primary text-white px-6 py-2 rounded-lg font-medium hover:bg-blue-700 transition-colors hover-lift shadow-sm">Login</a>
                <?php endif; ?>
            </div>
            <!-- Mobile menu button -->
            <div class="flex items-center sm:hidden">
                <button type="button" class="inline-flex items-center justify-center p-2 rounded-md text-slate-400 hover:text-slate-500 hover:bg-slate-100" aria-controls="mobile-menu" aria-expanded="false" onclick="document.getElementById('mobile-menu').classList.toggle('hidden')">
                    <span class="sr-only">Open main menu</span>
                    <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu -->
    <div class="sm:hidden hidden bg-white border-t border-slate-100" id="mobile-menu">
        <div class="pt-2 pb-3 space-y-1">
            <a href="<?php echo $base_url; ?>/public/laporan.php" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-slate-600 hover:bg-slate-50 hover:border-slate-300 hover:text-slate-800">Lihat Laporan</a>
            <a href="<?php echo $base_url; ?>/public/grafik.php" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-slate-600 hover:bg-slate-50 hover:border-slate-300 hover:text-slate-800">Lihat Grafik</a>
            <?php if(isset($_SESSION['user_id'])): ?>
                <a href="<?php echo $dashboard_url; ?>" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-primary hover:bg-slate-50 hover:border-slate-300">Dashboard</a>
            <?php else: ?>
                <a href="<?php echo $base_url; ?>/public/login.php" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-primary hover:bg-slate-50 hover:border-slate-300">Login</a>
            <?php endif; ?>
        </div>
    </div>
</nav>
<!-- Main Content Container -->
<main class="flex-grow">
