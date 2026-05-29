<?php
// includes/auth.php

session_start();

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function requireLogin() {
    if (!isLoggedIn()) {
        redirect('../public/login.php');
    }
}

function requireRole($role) {
    requireLogin();
    if ($_SESSION['role'] !== $role) {
        // Redirect unauthorized users based on their actual role
        if ($_SESSION['role'] === 'admin') {
            redirect('../admin/index.php');
        } elseif ($_SESSION['role'] === 'bendahara') {
            redirect('../bendahara/index.php');
        } elseif ($_SESSION['role'] === 'kepala_desa') {
            redirect('../kepala_desa/index.php');
        } else {
            redirect('../public/login.php');
        }
    }
}
?>
