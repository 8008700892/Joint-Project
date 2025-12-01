<?php

// product creation handler

require_once '../includes/adminAuth.php';
require_once '../includes/Database.php';
require_once '../includes/ProductCRUD.php';

// Only run if POST request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // collect form inputs
    $name        = trim($_POST['name'] ?? '');
    $price       = trim($_POST['price'] ?? '');
    $category    = trim($_POST['category'] ?? '');
    $description = trim($_POST['description'] ?? '');

    // default: no image
    $image_path  = '';

    // only process image if a file was uploaded
    if (!empty($_FILES['image_path']['name'])) {


        $imageName = time() . '_' . basename($_FILES['image_path']['name']);

        // store in uploads
        $uploadDir  = '../uploads/';
        $targetFile = $uploadDir . $imageName;


        move_uploaded_file($_FILES['image_path']['tmp_name'], $targetFile);

        $image_path = 'uploads/' . $imageName;
    }

    $database = new Database();
    $db = $database->getConnection();
    $productCRUD = new ProductCRUD($db);

    // data array for validation/create
    $data = [
        'name'        => $name,
        'price'       => $price,
        'category'    => $category,
        'image_path'  => $image_path,
        'description' => $description
    ];

    // Validate product input before create
    $errors = $productCRUD->validateProduct($data);

    if (!empty($errors)) {
        // Convert errors into a readable string
        $error_string = implode(' | ', $errors);

        // Redirect back with error message
        $redirect_url = 'adminProducts.php?status=error'
            . '&error_message=' . urlencode($error_string);

        header("Location: $redirect_url");
        exit;
    }

    // Create the product in database
    $result = $productCRUD->createProduct($data);

    if ($result['success'] === true) {
        // if successful redirect with success message
        $redirect_url = 'adminProducts.php?status=success'
            . '&success_message=' . urlencode($result['message']);

        header("Location: $redirect_url");
        exit;
    } else {
        // if failure redirect with error message
        $redirect_url = 'adminProducts.php?status=error'
            . '&error_message=' . urlencode($result['message']);

        header("Location: $redirect_url");
        exit;
    }

} else {
    // send back to admin product page if this file is accessed directly
    header("Location: adminProducts.php");
    exit;
}
