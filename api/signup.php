<?php
header("Content-Type: application/json");
require_once __DIR__ . '/../config/db.php';

// Receive JSON from axios
$input = json_decode(file_get_contents("php://input"), true);

$username = $input['username'] ?? '';
$password = $input['password'] ?? '';

if (!$username || !$password) {
    http_response_code(400);
    echo json_encode(["message" => "Username and password required"]);
    exit;
}

// Find user
$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    http_response_code(401);
    echo json_encode(["message" => "Invalid username or password"]);
    exit;
}

// Verify hashed password
if (!password_verify($password, $user['password'])) {
    http_response_code(401);
    echo json_encode(["message" => "Invalid username or password"]);
    exit;
}

// Success login
http_response_code(200);
echo json_encode([
    "message" => "Login successful",
    "user" => [
        "id" => $user['id'],
        "username" => $user['username'],
    ]
]);
exit;
