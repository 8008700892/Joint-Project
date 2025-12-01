<?php
require_once 'Database.php';

// This class handles all the CRUD operations logic for the site products

class ProductCRUD {
    private $conn;
    private $table_name = 'products';

    // Constructor for database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // Server side validation for products
    public function validateProduct($data){
        $errors = [];

        // Name: required, less than 255 chars
        if (empty($data['name'])) {
            $errors['name'] = "Product name is required";
        } elseif (strlen($data['name']) > 255) {
            $errors['name'] = "Product name must be less than 255 characters";
        }

        // Price: required, digits only, and greater than 0
        if ($data['price'] === '' || !isset($data['price'])) {
            $errors['price'] = "Product must have a price";
        } elseif (!is_numeric($data['price'])) {
            $errors['price'] = "Product price must be a number";
        } elseif ($data['price'] <= 0) {
            $errors['price'] = "Product price must be greater than 0";
        }

        // Description: required
        if (empty($data['description'])) {
            $errors['description'] = "Product must have a description";
        }

        // Image path: required
        if (empty($data['image_path'])){
            $errors['image_path'] = "Product must have an image path";
        }

        // Category: optional, less than 100 chars
        if (strlen($data['category'] ?? '') > 100){
            $errors['category'] = "Product category must be less than 100 characters";
        }

        return $errors;
    }

    // CREATE Product
    public function createProduct($data){
        // Check for product validation errors
        $errors = $this->validateProduct($data);
        if (!empty($errors)) {
            return [
                'success' => false,
                'message' => 'There were product validation errors',
                'errors' => $errors
            ];
        }

        // Sanitize/Clean data
        $name = htmlspecialchars(strip_tags($data['name']));
        $price = htmlspecialchars(strip_tags($data['price']));
        $description = htmlspecialchars(strip_tags($data['description']));
        $category = htmlspecialchars(strip_tags($data['category'] ?? ''));
        $image_path = htmlspecialchars(strip_tags($data['image_path']));

        // Prepared statements to protect against SQL injection
        $query = "INSERT INTO " . $this->table_name . " 
        (name, price, description, category, image_path) 
        VALUES (:name, :price, :description, :category, :image_path)";

        $stmt = $this->conn->prepare($query);

        // Bind Parameters
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':category', $category);
        $stmt->bindParam(':image_path', $image_path);

        if ($stmt->execute()) {
            return ['success' => true, 'message' => 'Product created successfully'];
        } else{
            return ['success' => false, 'message' => 'Product not created'];
        }
    }

    // READ ALL PRODUCTS
    public function readAllProducts(){
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        // $stmt contains all the products and can be looped through
        return $stmt;
    }

    // READ single product, selected by id
    public function readOneProduct($id){
        // only return one row/product
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);

        $clean_id = htmlspecialchars(strip_tags($id));
        $stmt->bindParam(1, $clean_id);

        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // UPDATE product
    public function updateProduct($id, $data){
        // Validate
        $errors = $this->validateProduct($data);
        if (!empty($errors)) {
            return [
                'success' => false,
                'message' => 'They were product validation errors',
                'errors' => $errors
            ];
        }

        // Sanitize/Clean data
        $clean_id = htmlspecialchars(strip_tags($id));
        $name = htmlspecialchars(strip_tags($data['name']));
        $price = htmlspecialchars(strip_tags($data['price']));
        $description = htmlspecialchars(strip_tags($data['description']));
        $category = htmlspecialchars(strip_tags($data['category'] ?? ''));
        $image_path = htmlspecialchars(strip_tags($data['image_path']));

        // Update the product info
        $query = "UPDATE " . $this->table_name . "
        SET name = :name,
        price = :price,
        description = :description,
        category = :category,
        image_path = :image_path
        WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        // Bind parameters
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':category', $category);
        $stmt->bindParam(':image_path', $image_path);
        $stmt->bindParam(':id', $clean_id);

        if ($stmt->execute()) {
            return ['success' => true, 'message' => 'Product updated successfully'];
        } else{
            return ['success' => false, 'message' => 'Product not updated'];
        }
    }

    // DELETE operation
    public function deleteProduct($id){
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);

        $clean_id = htmlspecialchars(strip_tags($id));
        $stmt->bind_Param(1, $clean_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0){
                return ['success' => true, 'message' => 'Product deleted successfully'];
            }
            return ['success' => true, 'message' => 'Product not found or already deleted'];
        }
        return ['success' => false, 'message' => 'Product not deleted'];
    }

}