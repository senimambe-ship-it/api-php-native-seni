<?php
namespace Src\Controllers;

class UserController {

    // Endpoint untuk menampilkan semua user
    public function index() {
        echo json_encode([
            "success" => true,
            "data" => [
                [
                    "id" => 1,
                    "name" => "Admin",
                    "email" => "admin@example.com"
                ],
                [
                    "id" => 2,
                    "name" => "Novi",
                    "email" => "novi@example.com"
                ]
            ]
        ]);
    }

    // Endpoint untuk menampilkan user berdasarkan ID
    public function show($id) {
        echo json_encode([
            "success" => true,
            "data" => [
                "id" => $id,
                "name" => "User $id"
            ]
        ]);
    }
}
