<?php

// update handler

require_once '../includes/adminAuth.php';   // only logged-in admins can update
require_once '../includes/Database.php';
require_once '../includes/ProductCRUD.php';

// run if POST request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // collect form inputs
    $id          = trim($_POST['id'] ?? '');
    $name        = trim($_POST['name'] ?? '');
    $price       = trim($_POST['price'] ?? '');
    $category    = trim($_POST['category'] ?? '');
    $image_path  = trim($_POST['image_path'] ?? '');
    $description = trim($_POST['description'] ?? '');

    // Validate ID
    if ($id === '' || !is_numeric($id)) {
        $redirect_url = 'adminProducts.php?status=error'
            . '&error_message=' . urlencode('Invalid product ID.');
        header("Location: $redirect_url");
        exit;
    }

    // Connect to database
    $database = new Database();
    $db = $database->getConnection();
    $productCRUD = new ProductCRUD($db);

    // data array for validation and update
    $data = [
        'id'          => $id,
        'name'        => $name,
        'price'       => $price,
        'category'    => $category,
        'image_path'  => $image_path,
        'description' => $description
    ];

    // Validate product input before updating
    $errors = $productCRUD->validateProduct($data);

    if (!empty($errors)) {
        // validation errors into a string
        $error_string = implode(' | ', $errors);

        // Redirect back to edit page with errors
        $redirect_url = 'adminProductEdit.php?id=' . urlencode($id)
            . '&status=error'
            . '&error_message=' . urlencode($error_string);

        header("Location: $redirect_url");
        exit;
    }

    // update product in database
    $result = $productCRUD->updateProduct($data);

    if ($result['success'] === true) {
        // if success back to main products page
        $redirect_url = 'adminProducts.php?status=success'
            . '&success_message=' . urlencode($result['message']);

        header("Location: $redirect_url");
        exit;
    } else {
        // if failure back to edit page with error
        $redirect_url = 'adminProductEdit.php?id=' . urlencode($id)
            . '&status=error'
            . '&error_message=' . urlencode($result['message']);

        header("Location: $redirect_url");
        exit;
    }

} else {
    // send back to admin products page if this is accessed directly
    header("Location: adminProducts.php");
    exit;
}