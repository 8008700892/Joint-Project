<?php

// This file protects admin pages

// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    // if not logged in redirect back to login page
    $redirect_url = '../admin/adminLogin.php?status=error'
        . '&error_message=' . urlencode('Please login to access this page.');

    header("Location: $redirect_url");
    exit;
}