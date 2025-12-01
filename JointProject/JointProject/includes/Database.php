<?php


class Database{

    private $host = "localhost";
    private $port = "3307";
    private $db_name = "dbay_project";
    private $username = "root";
    private $password = "";
    public $conn;



    public function getConnection(){
        $this->conn = null;
        try{
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->db_name,
                $this->username,
                $this->password
            );

            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e){
            echo "Connection error: " . $e->getMessage();
        }
        return $this->conn;
    }

}