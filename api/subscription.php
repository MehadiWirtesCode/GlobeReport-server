<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

require_once __DIR__ . '/../config/db.php';

$input = json_decode(file_get_contents("php://input"), true);

$level  = $input['level'] ?? '';
$amount = $input['amount'] ?? '';
$email  = $input['email'] ?? '';

if (!$level || !$amount || !$email) {
    http_response_code(400);
    echo json_encode(["message" => "All fields are required"]);
    exit;
}

try {
    $sql = "INSERT INTO subscription (level, amount, email) VALUES (:level, :amount, :email)";
    $stmt = $pdo->prepare($sql);

    $result = $stmt->execute([
        'level'  => $level,
        'amount' => $amount,
        'email'  => $email
    ]);

    if ($result) {
        http_response_code(201);
        echo json_encode(["message" => "Subscription successful!"]);
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["message" => "Error: " . $e->getMessage()]);
}
exit;
