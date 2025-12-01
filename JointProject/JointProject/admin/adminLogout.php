<?php
// Logs the admin out and redirects back to the login page.

// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// clear all session variables
$_SESSION = [];

// destroy the session
session_destroy();

// Redirect back to login page with  success message
$redirect_url = 'adminLogin.php?status=success'
    . '&success_message=' . urlencode('You have been logged out.');

header("Location: $redirect_url");
exit;