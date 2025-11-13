<?php
class Database {
    private $host = "localhost";
    private $db_name = "apiphpseni"; // ganti sesuai nama database kamu
    private $username = "root";
    private $password = "";
    public $conn;

    public function connect() {
        $this->conn = null;
        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name,
                $this->username,
                $this->password
            );
            $this->conn->exec("set names utf8");
        } catch (PDOException $exception) {
            echo json_encode(["success" => false, "message" => "Koneksi gagal: " . $exception->getMessage()]);
            exit;
        }
        return $this->conn;
    }
}
