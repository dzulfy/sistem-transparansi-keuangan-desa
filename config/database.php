<?php
// config/database.php
date_default_timezone_set('Asia/Jakarta');

define('DB_HOST', 'sql111.infinityfree.com');
define('DB_USER', 'if0_41709109');
define('DB_PASS', 'f3FGQXQ5abU');
define('DB_NAME', 'if0_41709109_keuangandesa');

try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER, DB_PASS);
    
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Set default fetch mode to associative array
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>