<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


header("Content-Type: application/json");
require_once __DIR__ . '/../config/db.php';

$input = json_decode(file_get_contents("php://input"), true);

$username = $input['username'] ?? '';
$password = $input['password'] ?? '';

if (!$username || !$password) {
    http_response_code(400);
    echo json_encode(["message" => "Username and password required"]);
    exit;
}

$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user || !password_verify($password, $user['password'])) {
    http_response_code(401);
    echo json_encode(["message" => "Invalid username or password"]);
    exit;
}

echo json_encode([
    "message" => "Login successful",
    "user" => [
        "id" => $user['id'],
        "username" => $user['username']
    ]
]);
http_response_code(200);
