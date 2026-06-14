<?php
require_once 'config/database.php';
require_once 'includes/functions.php';
require_once 'includes/auth.php';

if (isLoggedIn()) {
    if ($_SESSION['role'] === 'admin') redirect('admin/index.php');
    if ($_SESSION['role'] === 'bendahara') redirect('bendahara/index.php');
    if ($_SESSION['role'] === 'kepala_desa') redirect('kepala_desa/index.php');
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitize($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        $error = "Username dan password wajib diisi.";
    } else {
        $stmt = $pdo->prepare("SELECT * FROM user WHERE username = ? LIMIT 1");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id_user'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['nama'] = $user['nama'];
            $_SESSION['role'] = $user['role'];

            // Log login activity
            logAktivitas($pdo, $user['id_user'], "Melakukan login ke sistem.");

            if ($user['role'] === 'admin') redirect('admin/index.php');
            if ($user['role'] === 'bendahara') redirect('bendahara/index.php');
            if ($user['role'] === 'kepala_desa') redirect('kepala_desa/index.php');
        } else {
            $error = "Username atau password salah.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Transparansi Keuangan Desa</title>
    
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
</head>
<body class="bg-secondary font-sans text-slate-800 antialiased min-h-screen flex flex-col justify-center py-12 sm:px-6 lg:px-8">

<div class="sm:mx-auto sm:w-full sm:max-w-md">
    <div class="flex justify-center">
        <div class="h-14 w-14 bg-navy-800 text-white rounded-2xl flex items-center justify-center shadow-lg transform rotate-3">
            <svg class="h-8 w-8 -rotate-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
            </svg>
        </div>
    </div>
    <h2 class="mt-6 text-center text-3xl font-extrabold text-navy-900">Masuk ke Sistem</h2>
    <p class="mt-2 text-center text-sm text-slate-600">Sistem Transparansi Keuangan Desa</p>
</div>

<div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
    <div class="bg-white py-8 px-4 shadow-xl sm:rounded-2xl sm:px-10 border border-slate-100">
        
        <?php if($error): ?>
            <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-md">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-red-700"><?php echo $error; ?></p>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <form class="space-y-6" action="login.php" method="POST">
            <div>
                <label for="username" class="block text-sm font-medium text-slate-700">Username</label>
                <div class="mt-1 relative rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <input id="username" name="username" type="text" required class="block w-full pl-10 pr-3 py-2.5 border border-slate-300 rounded-lg focus:ring-primary focus:border-primary sm:text-sm transition-colors" placeholder="Masukkan username">
                </div>
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-slate-700">Password</label>
                <div class="mt-1 relative rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <input id="password" name="password" type="password" required class="block w-full pl-10 pr-10 py-2.5 border border-slate-300 rounded-lg focus:ring-primary focus:border-primary sm:text-sm transition-colors" placeholder="••••••••">
                    <!-- Toggle password visibility could be added here -->
                </div>
            </div>

            <div class="bg-blue-50 border border-blue-100 rounded-lg p-4 flex gap-3">
                <svg class="h-5 w-5 text-primary flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="text-xs text-blue-800 leading-relaxed">
                    Sistem ini dilindungi oleh enkripsi standar pemerintah. Akses tidak sah akan dicatat dan dapat ditindak secara hukum.
                </p>
            </div>

            <div>
                <button type="submit" class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-primary hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors">
                    Masuk &rarr;
                </button>
            </div>
            
            <div class="text-center mt-4">
                <a href="<?php echo getBaseUrl(); ?>/index.php" class="text-sm text-slate-500 hover:text-primary">&larr; Kembali ke Beranda</a>
            </div>
        </form>
    </div>
</div>

</body>
</html>
