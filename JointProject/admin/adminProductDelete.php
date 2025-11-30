<?php

// delete page handler

require_once '../includes/adminAuth.php';  // only logged in admins can delete
require_once '../includes/Database.php';
require_once '../includes/ProductCRUD.php';

// Confirm id was passed in query string
$id = $_GET['id'] ?? '';

if ($id === '' || !is_numeric($id)) {
    // if missing or invalid id
    $redirect_url = 'adminProducts.php?status=error'
        . '&error_message=' . urlencode('Invalid product ID.');
    header("Location: $redirect_url");
    exit;
}

// connect to database and CRUD
$database = new Database();
$db = $database->getConnection();
$productCRUD = new ProductCRUD($db);

// Call delete method
$result = $productCRUD->deleteProduct($id);


if ($result['success'] === true) {

    $redirect_url = 'adminProducts.php?status=success'
        . '&success_message=' . urlencode($result['message']);

    header("Location: $redirect_url");
    exit;

} else {

    $redirect_url = 'adminProducts.php?status=error'
        . '&error_message=' . urlencode($result['message']);

    header("Location: $redirect_url");
    exit;
}