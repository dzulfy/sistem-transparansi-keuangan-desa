<?php
require_once 'includes/header.php';
require_once 'config/mail.php';
require_once 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
?>

<!-- Page Header -->
<div class="bg-white border-b border-cardBorder">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="text-center">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-primary mb-3">
                <svg class="mr-1.5 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                Hubungi Kami
            </span>
            <h1 class="text-4xl font-extrabold text-navy-900 sm:text-5xl">Kontak Kami</h1>
            <p class="mt-4 text-lg text-slate-500 max-w-2xl mx-auto">
                Kami siap membantu menjawab pertanyaan dan menerima masukan Anda terkait transparansi keuangan Desa Purwadana.
            </p>
        </div>
    </div>
</div>

<!-- Content -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">

        <!-- Info Cards -->
        <div class="space-y-6">
            <!-- Alamat -->
            <div class="bg-white rounded-2xl p-6 border border-cardBorder shadow-sm hover-lift">
                <div class="h-12 w-12 bg-blue-100 text-primary rounded-xl flex items-center justify-center mb-4">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <h3 class="text-base font-bold text-navy-900 mb-1">Alamat Kantor</h3>
                <p class="text-sm text-slate-600 leading-relaxed">
                    Jl. Bobojong No. 1 Desa Purwadana,<br>
                    Kec. Telukjambe Timur,<br>
                    Kab. Karawang, Jawa Barat 41361
                </p>
            </div>

            <!-- Telepon -->
            <div class="bg-white rounded-2xl p-6 border border-cardBorder shadow-sm hover-lift">
                <div class="h-12 w-12 bg-green-100 text-green-600 rounded-xl flex items-center justify-center mb-4">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                </div>
                <h3 class="text-base font-bold text-navy-900 mb-1">Telepon / WhatsApp</h3>
                <p class="text-sm text-slate-600">0838-4141-5159</p>
                <a href="https://wa.me/6283841415159" target="_blank" class="inline-flex items-center mt-2 text-sm text-green-600 font-medium hover:underline">
                    <svg class="mr-1.5 h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                    </svg>
                    Chat WhatsApp
                </a>
            </div>

            <!-- Email -->
            <div class="bg-white rounded-2xl p-6 border border-cardBorder shadow-sm hover-lift">
                <div class="h-12 w-12 bg-purple-100 text-purple-600 rounded-xl flex items-center justify-center mb-4">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <h3 class="text-base font-bold text-navy-900 mb-1">Email</h3>
                <a href="mailto:refiabdillah19@gmail.com" class="text-sm text-primary hover:underline break-all">
                    refiabdillah19@gmail.com
                </a>
                <p class="text-xs text-slate-400 mt-1">Respon dalam 1–2 hari kerja</p>
            </div>

            <!-- Jam Operasional -->
            <div class="bg-white rounded-2xl p-6 border border-cardBorder shadow-sm hover-lift">
                <div class="h-12 w-12 bg-yellow-100 text-yellow-600 rounded-xl flex items-center justify-center mb-4">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="text-base font-bold text-navy-900 mb-2">Jam Operasional</h3>
                <div class="space-y-1 text-sm text-slate-600">
                    <div class="flex justify-between"><span>Senin – Kamis</span><span class="font-medium">08.00 – 16.00</span></div>
                    <div class="flex justify-between"><span>Jumat</span><span class="font-medium">08.00 – 11.30</span></div>
                    <div class="flex justify-between"><span>Sabtu – Minggu</span><span class="font-medium text-red-500">Tutup</span></div>
                </div>
            </div>
        </div>

        <!-- Form Pesan -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl border border-cardBorder shadow-sm p-8">
                <h2 class="text-2xl font-bold text-navy-900 mb-2">Kirim Pesan</h2>
                <p class="text-slate-500 text-sm mb-8">Isi formulir di bawah ini dan tim kami akan menghubungi Anda sesegera mungkin.</p>

                <?php
                $sent = false;
                $formError = '';
                $nama = $email = $subjek = $pesan = '';

                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $nama   = htmlspecialchars(trim($_POST['nama']   ?? ''));
                    $email  = trim($_POST['email']  ?? '');
                    $subjek = htmlspecialchars(trim($_POST['subjek'] ?? ''));
                    $pesan  = htmlspecialchars(trim($_POST['pesan']  ?? ''));

                    if (empty($nama) || empty($email) || empty($subjek) || empty($pesan)) {
                        $formError = 'Semua field wajib diisi.';
                    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        $formError = 'Format email tidak valid.';
                    } else {
                        // Kirim email via PHPMailer
                        $mail = new PHPMailer(true);
                        try {
                            // Server settings
                            $mail->isSMTP();
                            $mail->Host       = MAIL_HOST;
                            $mail->SMTPAuth   = true;
                            $mail->Username   = MAIL_USERNAME;
                            $mail->Password   = MAIL_PASSWORD;
                            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                            $mail->Port       = MAIL_PORT;
                            $mail->CharSet    = 'UTF-8';

                            // Pengirim & Penerima
                            $mail->setFrom(MAIL_FROM_EMAIL, MAIL_FROM_NAME);
                            $mail->addAddress(MAIL_TO_EMAIL, MAIL_TO_NAME);
                            $mail->addReplyTo(htmlspecialchars($email), $nama);

                            // Konten email HTML
                            $mail->isHTML(true);
                            $mail->Subject = '[STKD Kontak] ' . $subjek . ' - dari ' . $nama;
                            $mail->Body    = '
<div style="font-family:Inter,sans-serif;max-width:600px;margin:0 auto;border:1px solid #dbeafe;border-radius:12px;overflow:hidden">
  <div style="background:#2563eb;padding:24px 32px">
    <h2 style="color:#fff;margin:0;font-size:20px">Pesan Masuk dari Form Kontak</h2>
    <p style="color:#bfdbfe;margin:4px 0 0;font-size:13px">STKD Desa Purwadana</p>
  </div>
  <div style="padding:32px;background:#f8fafc">
    <table style="width:100%;border-collapse:collapse;font-size:14px">
      <tr><td style="padding:10px 0;color:#64748b;width:130px">Nama</td><td style="padding:10px 0;font-weight:600;color:#0f172a">' . $nama . '</td></tr>
      <tr><td style="padding:10px 0;color:#64748b">Email</td><td style="padding:10px 0;color:#2563eb"><a href="mailto:' . htmlspecialchars($email) . '" style="color:#2563eb">' . htmlspecialchars($email) . '</a></td></tr>
      <tr><td style="padding:10px 0;color:#64748b">Subjek</td><td style="padding:10px 0;font-weight:600;color:#0f172a">' . $subjek . '</td></tr>
      <tr><td style="padding:10px 0;color:#64748b;vertical-align:top">Pesan</td><td style="padding:10px 0;color:#334155;line-height:1.6">' . nl2br($pesan) . '</td></tr>
      <tr><td style="padding:10px 0;color:#64748b">Waktu</td><td style="padding:10px 0;color:#334155">' . date('d M Y, H:i') . ' WIB</td></tr>
    </table>
  </div>
  <div style="background:#eff6ff;padding:16px 32px;text-align:center">
    <p style="margin:0;font-size:12px;color:#94a3b8">&copy; ' . date('Y') . ' STKD Desa Purwadana &mdash; Sistem Transparansi Keuangan Desa</p>
  </div>
</div>';

                            $mail->AltBody = "Pesan dari: $nama\nEmail: $email\nSubjek: $subjek\n\n$pesan";

                            $mail->send();
                            $sent = true;
                        } catch (Exception $e) {
                            $formError = 'Gagal mengirim pesan. Silakan coba lagi atau hubungi kami langsung via WhatsApp. (Error: ' . $mail->ErrorInfo . ')';
                        }
                    }
                }
                ?>

                <?php if ($sent): ?>
                <div class="bg-green-50 border border-green-200 rounded-xl p-5 mb-6 flex items-start gap-3">
                    <svg class="h-6 w-6 text-green-500 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div>
                        <p class="font-semibold text-green-800">Pesan berhasil dikirim!</p>
                        <p class="text-sm text-green-700 mt-0.5">Terima kasih, <strong><?php echo $nama; ?></strong>. Kami akan membalas ke <strong><?php echo $email; ?></strong> dalam 1–2 hari kerja.</p>
                    </div>
                </div>
                <?php endif; ?>

                <?php if ($formError): ?>
                <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-6">
                    <p class="text-sm text-red-700"><?php echo $formError; ?></p>
                </div>
                <?php endif; ?>

                <form method="POST" action="kontak.php" class="space-y-5">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label for="nama" class="block text-sm font-medium text-slate-700 mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                            <input type="text" id="nama" name="nama" required
                                value="<?php echo isset($nama) ? $nama : ''; ?>"
                                class="w-full border border-slate-300 rounded-lg p-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition"
                                placeholder="Nama Anda">
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-slate-700 mb-1.5">Email <span class="text-red-500">*</span></label>
                            <input type="email" id="email" name="email" required
                                value="<?php echo isset($email) ? $email : ''; ?>"
                                class="w-full border border-slate-300 rounded-lg p-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition"
                                placeholder="email@contoh.com">
                        </div>
                    </div>
                    <div>
                        <label for="subjek" class="block text-sm font-medium text-slate-700 mb-1.5">Subjek <span class="text-red-500">*</span></label>
                        <select id="subjek" name="subjek" required
                            class="w-full border border-slate-300 rounded-lg p-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition bg-white">
                            <option value="">-- Pilih Subjek --</option>
                            <option value="Pertanyaan Umum" <?php echo (isset($subjek) && $subjek == 'Pertanyaan Umum') ? 'selected' : ''; ?>>Pertanyaan Umum</option>
                            <option value="Informasi Anggaran" <?php echo (isset($subjek) && $subjek == 'Informasi Anggaran') ? 'selected' : ''; ?>>Informasi Anggaran</option>
                            <option value="Laporan & Realisasi" <?php echo (isset($subjek) && $subjek == 'Laporan & Realisasi') ? 'selected' : ''; ?>>Laporan &amp; Realisasi</option>
                            <option value="Saran & Masukan" <?php echo (isset($subjek) && $subjek == 'Saran & Masukan') ? 'selected' : ''; ?>>Saran &amp; Masukan</option>
                            <option value="Lainnya" <?php echo (isset($subjek) && $subjek == 'Lainnya') ? 'selected' : ''; ?>>Lainnya</option>
                        </select>
                    </div>
                    <div>
                        <label for="pesan" class="block text-sm font-medium text-slate-700 mb-1.5">Pesan <span class="text-red-500">*</span></label>
                        <textarea id="pesan" name="pesan" rows="6" required
                            class="w-full border border-slate-300 rounded-lg p-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition resize-none"
                            placeholder="Tulis pesan Anda di sini..."><?php echo isset($pesan) ? $pesan : ''; ?></textarea>
                    </div>
                    <div class="pt-2">
                        <button type="submit"
                            class="inline-flex items-center px-8 py-3 bg-primary text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors hover-lift shadow-sm">
                            <svg class="mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                            </svg>
                            Kirim Pesan
                        </button>
                    </div>
                </form>
            </div>

            <!-- Google Maps Embed (placeholder iframe) -->
            <div class="mt-6 bg-white rounded-2xl border border-cardBorder shadow-sm overflow-hidden">
                <div class="p-5 border-b border-slate-100">
                    <h3 class="text-base font-bold text-navy-900">Lokasi Kantor Desa</h3>
                </div>
                <div class="relative w-full" style="height: 280px;">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d32139.470114242606!2d107.25404540568061!3d-6.290548546691749!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e699d4eed0ec1b7%3A0x35fe32e46e5f5034!2sPurwadana%2C%20Telukjambe%20Timur%2C%20Karawang%2C%20Jawa%20Barat!5e1!3m2!1sid!2sid!4v1781430172717!5m2!1sid!2sid" width="800" height="600" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>

    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
