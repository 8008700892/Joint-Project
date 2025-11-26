<?php

require_once 'Database.php';

// This class handles CRUD operations for the admins table

class AdminCRUD{
    // store the database connection
    private $conn;
    private $table_name = "admins";

    // Constructor for PDO connection object
    public function __construct($db){
        $this->conn = $db;
    }

    // CREATE admin (register admin)
    // $hashed_password is already hashed before calling this, already safe
    public function createAdmin($username, $email, $hashed_password){
        // validation to make sure fields are not empty
        if (empty($username) || empty($email) || empty($hashed_password)){
            return [
                "success" => false,
                "message" => "All fields are required to create admin account."
            ];
        }

        // Prepared statement to prevent sql injection
        $query = "INSERT INTO " . $this->table_name .
            "(username, email, password_hash)
            VALUES
            (:username, :email, :password_hash)";

        $stmt = $this->conn->prepare($query);

        // Sanitize/clean data
        $clean_username = htmlspecialchars(strip_tags($username));
        $clean_email = htmlspecialchars(strip_tags($email));

        // bind parameters
        $stmt->bindParam(':username', $clean_username);
        $stmt->bindParam(':email', $clean_email);
        $stmt->bindParam(':password_hash', $hashed_password);


        // Execute statement and return true or false based on success or fail
        if ($stmt->execute()) {
            return [
            'success' => true,
            "message" => "Admin account created successfully."
                ];
        }
        return [
            "success" => false,
            "message" => "Admin creation failed. Username or email might be taken."
        ];

    }

    // READ get all admins (admin list page)
    public function readAllAdmins(){
        $query = "SELECT id, username, email, role, created_at FROM " . $this->table_name .
            "ORDER BY id DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        // can loop through $stmt in the page
        return $stmt;
    }

    // Read one admin by ID
    public function readOneAdmin($id){
        $query = "SELECT id, username, email, role, created_at FROM " . $this->table_name . "
        WHERE id = ?
        LIMIT 1";

        $stmt = $this->conn->prepare($query);

        $clean_id = htmlspecialchars(strip_tags($id));
        $stmt->bindParam(1, $clean_id);
        $stmt->execute();
        // returns the admin details
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // UPDATE admin
    public function updateAdmin($id, $data){
        // validation if required fields are empty
        if (empty($username) || empty($email)){
            return false;
        }

        // prepared statement to prevent sql injection
        $query = "UPDATE " . $this->table_name . "
        SET username = :username,
        email = :email,
        role = :role
        WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        // Sanitize/clean values
        $clean_id = htmlspecialchars(strip_tags($id));
        $clean_username = htmlspecialchars(strip_tags($data['username']));
        $clean_email = htmlspecialchars(strip_tags($data['email']));
        $clean_role = htmlspecialchars(strip_tags($data['role'] ?? 'admin'));

        // bind parameters
        $stmt->bindParam(':username', $clean_username);
        $stmt->bindParam(':email', $clean_email);
        $stmt->bindParam(':role', $clean_role);
        $stmt->bindParam(':id', $clean_id);

        if ($stmt->execute()) {
            return ['success' => true, 'message' => 'Admin updated successfully'];
        } else{
            return ['success' => false, 'message' => 'Admin update failed'];
        }
    }

    // DELETE admin by id
    public function deleteAdmin($id){
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";

        $stmt = $this->conn->prepare($query);

        $clean_id = htmlspecialchars(strip_tags($id));
        $stmt->bindParam(1, $clean_id);

        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0){
                return ['success' => true, 'message' => 'Admin deleted successfully'];
            }
            return ['success' => true, 'message' => 'Admin not found or already deleted'];
        }
        return ['success' => false, 'message' => 'Admin delete failed'];
    }


}