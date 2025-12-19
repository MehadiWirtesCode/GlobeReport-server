<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

require_once __DIR__ . '/../config/db.php';

try {
    $stmt = $pdo->query("
        SELECT
            id,
            username,
            email,
            role,
            created_at
        FROM users
        ORDER BY created_at DESC
    ");

    $users = $stmt->fetchAll();

    $userData = array_map(function($row){
        return [
            "id" => $row["id"],
            "name" => $row["username"],
            "email" => $row["email"],
            "role" => $row["role"],
            "createdAt" => $row["created_at"]
        ];
    }, $users);

    echo json_encode([
        "message" => "Users loaded successfully",
        "users" => $userData
    ]);
    http_response_code(200);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        "message" => "Failed to fetch users",
        "error" => $e->getMessage()
    ]);
}
