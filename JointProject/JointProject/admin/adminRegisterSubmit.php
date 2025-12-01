<?php

// handles POST from admin register form


require_once '../includes/Database.php';
require_once '../includes/AdminCRUD.php';

// Only process if POST request
if ($_SERVER['REQUEST_METHOD'] == 'POST'){

    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $confirm_password = trim($_POST['confirm_password'] ?? '');

    $errors = [];

    // Validation for empty fields and password mismatch
    if (empty($username)){
        $errors['username'] = "Username is required";
    }
    if (empty($email)){
        $errors['email'] = "Email is required";
    }
    if (empty($password)){
        $errors['password'] = "Password is required";
    }
    if (empty($confirm_password)){
        $errors['confirm_password'] = "You must confirm your password";
    }
    if ($password !== '' && $confirm_password !== '' && $password !== $confirm_password){
        $errors['confirm_password'] = "Passwords do not match";
    }

    // Redirect if there are validation errors and display error message
    if (!empty($errors)){
        // join errors into a string
        $error_message = implode(' ', $errors);

        // keep username and email in the query
        $redirect_url = 'adminRegister.php?status=error'
        . '&error_message='. urlencode($error_message)
        . '&username='. urlencode($username)
        . '&email='. urlencode($email);
        header("Location: $redirect_url");
        exit;
    }

    // Hash the password if validation passed
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // create database connection and AdminCRUD
    $database = new Database();
    $db = $database->getConnection();
    $adminCrud = new AdminCRUD($db);

    // Call createAdmin
    $result = $adminCrud->createAdmin($username, $email, $hashed_password);

    if($result['success']){
        // if successful, redirect with success message and clear username and email fields
        $redirect_url = 'adminRegister.php?status=success'
            . '&success_message='. urlencode($result['message']);
        header("Location: $redirect_url");
        exit;
    } else{
        $redirect_url = 'adminRegister.php?status=error'
            . '&error_message='. urlencode($result['message'])
            . '&username='. urlencode($username)
            . '&email='. urlencode($email);
        header("Location: $redirect_url");
        exit;
    }


} else {
    // If file is submitted without POST, redirect to the form
    header("Location:adminRegister.php");
    exit;
}