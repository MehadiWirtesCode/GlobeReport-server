<?php
header("Content-Type: application/json");
require_once __DIR__ . '/../config/db.php';

$input = json_decode(file_get_contents("php://input"), true);

$username = $input['username'] ?? '';
$email    = $input['email'] ?? '';
$password = $input['password'] ?? '';
$confirmPassword = $input['confirmPassword'] ?? '';

if (!$username || !$email || !$password || !$confirmPassword) {
    http_response_code(400);
    echo json_encode(["message" => "All fields are required"]);
    exit;
}

if ($password !== $confirmPassword) {
    http_response_code(400);
    echo json_encode(["message" => "Passwords do not match"]);
    exit;
}

try {
    $checkSql = "SELECT id FROM users WHERE username = :username OR email = :email";
    $checkStmt = $pdo->prepare($checkSql);
    $checkStmt->execute(['username' => $username, 'email' => $email]);

    if ($checkStmt->fetch()) {
        http_response_code(400);
        echo json_encode(["message" => "Username or Email already exists"]);
        exit;
    }

    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    $sql = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
    $stmt = $pdo->prepare($sql);

    $result = $stmt->execute([
        'username' => $username,
        'email'    => $email,
        'password' => $hashedPassword
    ]);

    if ($result) {
        http_response_code(201);
        echo json_encode(["message" => "Signup successful!"]);
    }

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["message" => "Database Error: " . $e->getMessage()]);
}
exit;