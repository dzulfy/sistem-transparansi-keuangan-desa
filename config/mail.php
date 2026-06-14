<?php
// config/mail.php
// Konfigurasi SMTP untuk pengiriman email via Gmail
// Gunakan App Password Gmail, BUKAN password biasa.
// Cara buat App Password: myaccount.google.com > Security > 2-Step Verification > App passwords

define('MAIL_HOST',       'smtp.gmail.com');
define('MAIL_PORT',       587);                         // TLS
define('MAIL_USERNAME',   'refiabdillah19@gmail.com');  // Akun Gmail pengirim
define('MAIL_PASSWORD',   'vshn rnmj pmws utgj');    // Ganti dengan App Password Gmail Anda
define('MAIL_FROM_EMAIL', 'refiabdillah19@gmail.com');  // Alamat From
define('MAIL_FROM_NAME',  'STKD Desa Purwadana');       // Nama pengirim
define('MAIL_TO_EMAIL',   'refiabdillah19@gmail.com');  // Email tujuan (penerima pesan kontak)
define('MAIL_TO_NAME',    'Admin Desa Purwadana');       // Nama penerima
