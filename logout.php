<?php
// logout.php
require_once 'config/database.php';
require_once 'includes/functions.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['user_id'])) {
    logAktivitas($pdo, $_SESSION['user_id'], "Melakukan logout dari sistem.");
}

session_destroy();
header("Location: login.php");
exit;
