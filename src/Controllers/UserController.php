<?php
namespace Src\Controllers;

require_once __DIR__ . '/../../config/database.php';

use PDO;
use PDOException;

class UserController {
    private $conn;

    public function __construct() {
        $this->conn = (new \Database())->connect();
    }

    // GET - tampilkan semua user
    public function index() {
        $stmt = $this->conn->query("SELECT * FROM users");
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(["success" => true, "data" => $data]);
    }

    // GET - tampilkan user berdasarkan ID
    public function show($id) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode(["success" => true, "data" => $data]);
    }

    // POST - tambah user baru
    public function store() {
        $input = json_decode(file_get_contents("php://input"), true);
        $stmt = $this->conn->prepare("INSERT INTO users(username, email, password) VALUES(:u, :e, :p)");
        $stmt->execute([
            ":u" => $input['username'],
            ":e" => $input['email'],
            ":p" => password_hash($input['password'], PASSWORD_DEFAULT)
        ]);
        echo json_encode(["success" => true, "message" => "User berhasil ditambahkan"]);
    }

    // PUT - ubah data user
    public function update($id) {
        $input = json_decode(file_get_contents("php://input"), true);
        $stmt = $this->conn->prepare("UPDATE users SET username=:u, email=:e WHERE id=:id");
        $stmt->execute([
            ":u" => $input['username'],
            ":e" => $input['email'],
            ":id" => $id
        ]);
        echo json_encode(["success" => true, "message" => "User berhasil diupdate"]);
    }

    // DELETE - hapus user
    public function destroy($id) {
        $stmt = $this->conn->prepare("DELETE FROM users WHERE id=:id");
        $stmt->execute([':id' => $id]);
        echo json_encode(["success" => true, "message" => "User berhasil dihapus"]);
    }
}
