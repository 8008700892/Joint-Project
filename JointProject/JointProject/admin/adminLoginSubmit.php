<?php

// Login form handler

require_once '../includes/Database.php';
require_once '../includes/AdminCRUD.php';

// Only process POST requests
if ($_SERVER['REQUEST_METHOD'] == 'POST'){

    // Collect inputs
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    // Required fields check
    if ($email === '' || $password === ''){
        $redirect_url = 'adminLogin.php?status=error'
            . '&error_message=' . urlencode('Email and password are required.')
            . '&email=' . urlencode($email);
        header("Location: $redirect_url");
        exit;
    }


    $database = new Database();
    $db = $database->getConnection();

    try {
        // Lookup admin by email
        $query = "SELECT id, username, email, password_hash, role
                  FROM admins
                  WHERE email = :email
                  LIMIT 1";

        $stmt = $db->prepare($query);

        $clean_email = htmlspecialchars(strip_tags($email));
        $stmt->bindParam(':email', $clean_email);

        $stmt->execute();

        // If admin exists verify password
        if ($stmt->rowCount() === 1){
            $admin = $stmt->fetch(PDO::FETCH_ASSOC);

            if (password_verify($password, $admin['password_hash'])){

                // start session
                session_start();
                $_SESSION['admin_id'] = $admin['id'];
                $_SESSION['admin_username'] = $admin['username'];
                $_SESSION['admin_email'] = $admin['email'];
                $_SESSION['admin_role'] = $admin['role'];

                // Redirect to admin products page
                $redirect_url = 'adminProducts.php?status=success'
                    . '&success_message=' . urlencode('Logged in successfully.');
                header("Location: $redirect_url");
                exit;
            }
        }

        // if no admin found or wrong password
        $redirect_url = 'adminLogin.php?status=error'
            . '&error_message=' . urlencode('Invalid email or password.')
            . '&email=' . urlencode($email);
        header("Location: $redirect_url");
        exit;

    } catch (PDOException $e){
        // error message for database issues
        $redirect_url = 'adminLogin.php?status=error'
            . '&error_message=' . urlencode('There was a problem logging in. Please try again.')
            . '&email=' . urlencode($email);
        header("Location: $redirect_url");
        exit;
    }

} else {
    // If accessed without POST, redirect back to login form
    header("Location: adminLogin.php");
    exit;
}