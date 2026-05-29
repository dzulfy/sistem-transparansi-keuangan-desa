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
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
    $host = $_SERVER['HTTP_HOST'];
    $scriptName = dirname($_SERVER['SCRIPT_NAME']);
    // if script is deeply nested, return to the root 'rpl' folder. For simplicity we assume '/rpl/' is the base.
    // Adjust this to match your local setup
    return $protocol . "://" . $host . "/rpl"; 
}
?>
