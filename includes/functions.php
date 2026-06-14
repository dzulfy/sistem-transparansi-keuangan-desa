<?php
// includes/functions.php

function formatRupiah($angka) {
    return "Rp " . number_format($angka, 0, ',', '.');
}

function sanitize($input) {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

function redirect($url) {
    header("Location: $url");
    exit;
}

function logAktivitas($pdo, $id_user, $aktivitas) {
    $stmt = $pdo->prepare("INSERT INTO log_aktivitas (id_user, aktivitas) VALUES (?, ?)");
    $stmt->execute([$id_user, $aktivitas]);
}

function getBaseUrl() {
    return "https://desapurwadana.my.id"; 
}
?>
