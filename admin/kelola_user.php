<?php
require_once '../config/database.php';
require_once '../includes/functions.php';
require_once '../includes/auth.php';
requireRole('admin');

$error = '';
$success = '';

// Handle Delete
if (isset($_GET['delete'])) {
    $id_user = (int)$_GET['delete'];
    if ($id_user !== $_SESSION['user_id']) {
        $stmt = $pdo->prepare("DELETE FROM user WHERE id_user = ?");
        $stmt->execute([$id_user]);
        logAktivitas($pdo, $_SESSION['user_id'], "Menghapus user dengan ID: $id_user");
        $success = "User berhasil dihapus.";
    } else {
        $error = "Tidak dapat menghapus akun sendiri.";
    }
}

// Handle Add/Edit Form Submission (Simplified for this task)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = sanitize($_POST['nama']);
    $username = sanitize($_POST['username']);
    $role = $_POST['role'];
    
    if (isset($_POST['id_user']) && !empty($_POST['id_user'])) {
        // Update
        $id_user = (int)$_POST['id_user'];
        if (!empty($_POST['password'])) {
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
            $stmt = $pdo->prepare("UPDATE user SET nama=?, username=?, password=?, role=? WHERE id_user=?");
            $stmt->execute([$nama, $username, $password, $role, $id_user]);
        } else {
            $stmt = $pdo->prepare("UPDATE user SET nama=?, username=?, role=? WHERE id_user=?");
            $stmt->execute([$nama, $username, $role, $id_user]);
        }
        logAktivitas($pdo, $_SESSION['user_id'], "Mengubah data user ID: $id_user");
        $success = "Data user berhasil diperbarui.";
    } else {
        // Insert
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        try {
            $stmt = $pdo->prepare("INSERT INTO user (nama, username, password, role) VALUES (?, ?, ?, ?)");
            $stmt->execute([$nama, $username, $password, $role]);
            logAktivitas($pdo, $_SESSION['user_id'], "Menambahkan user baru: $username");
            $success = "User baru berhasil ditambahkan.";
        } catch(PDOException $e) {
            $error = "Gagal menambahkan user. Username mungkin sudah digunakan.";
        }
    }
}

// Fetch all users
$stmt = $pdo->query("SELECT * FROM user ORDER BY id_user DESC");
$users = $stmt->fetchAll();

require_once '../includes/sidebar_admin.php';
?>

<div class="flex justify-between items-center mb-8">
    <div>
        <h2 class="text-2xl font-bold text-navy-900">Kelola User</h2>
        <p class="text-slate-500">Manajemen pengguna sistem</p>
    </div>
</div>

<?php if($error): ?>
    <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-md">
        <p class="text-sm text-red-700"><?php echo $error; ?></p>
    </div>
<?php endif; ?>

<?php if($success): ?>
    <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded-md">
        <p class="text-sm text-green-700"><?php echo $success; ?></p>
    </div>
<?php endif; ?>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Form -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
            <h3 class="text-lg font-bold text-navy-900 mb-4">Tambah / Edit User</h3>
            <form action="kelola_user.php" method="POST" class="space-y-4">
                <input type="hidden" name="id_user" id="form_id_user" value="">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Nama Lengkap</label>
                    <input type="text" name="nama" id="form_nama" required class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary p-2 border">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Username</label>
                    <input type="text" name="username" id="form_username" required class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary p-2 border">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Password</label>
                    <input type="password" name="password" id="form_password" class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary p-2 border" placeholder="Kosongkan jika tidak diubah (untuk edit)">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Role</label>
                    <select name="role" id="form_role" required class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary p-2 border">
                        <option value="admin">Admin</option>
                        <option value="bendahara">Bendahara</option>
                        <option value="kepala_desa">Kepala Desa</option>
                    </select>
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="flex-1 bg-primary text-white py-2 rounded-lg font-medium hover:bg-blue-700 transition-colors">
                        Simpan
                    </button>
                    <button type="button" onclick="resetForm()" class="px-4 bg-slate-200 text-slate-700 py-2 rounded-lg font-medium hover:bg-slate-300 transition-colors">
                        Reset
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Table -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Username</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Role</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold text-slate-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        <?php foreach($users as $u): ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-navy-900"><?php echo htmlspecialchars($u['nama']); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500"><?php echo htmlspecialchars($u['username']); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs font-medium bg-slate-100 text-slate-800 rounded-md uppercase"><?php echo str_replace('_', ' ', $u['role']); ?></span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                <button onclick="editUser(<?php echo $u['id_user']; ?>, '<?php echo htmlspecialchars($u['nama']); ?>', '<?php echo htmlspecialchars($u['username']); ?>', '<?php echo htmlspecialchars($u['role']); ?>')" class="text-blue-500 hover:text-blue-700 mr-3">Edit</button>
                                <?php if($u['id_user'] !== $_SESSION['user_id']): ?>
                                <a href="kelola_user.php?delete=<?php echo $u['id_user']; ?>" onclick="return confirm('Yakin ingin menghapus user ini?')" class="text-red-500 hover:text-red-700">Hapus</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
function editUser(id, nama, username, role) {
    document.getElementById('form_id_user').value = id;
    document.getElementById('form_nama').value = nama;
    document.getElementById('form_username').value = username;
    document.getElementById('form_role').value = role;
    document.getElementById('form_password').required = false;
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function resetForm() {
    document.getElementById('form_id_user').value = '';
    document.getElementById('form_nama').value = '';
    document.getElementById('form_username').value = '';
    document.getElementById('form_role').value = 'admin';
    document.getElementById('form_password').required = true;
}
</script>

<?php require_once '../includes/dashboard_footer.php'; ?>
