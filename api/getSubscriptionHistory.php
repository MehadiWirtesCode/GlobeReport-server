<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require_once __DIR__ . '/../config/db.php';

$email = isset($_GET['email']) ? trim($_GET['email']) : '';

if (empty($email)) {
    echo json_encode(["history" => []]);
    exit;
}

try {
    $sql = "SELECT level, amount, created_at
            FROM subscription
            WHERE LOWER(email) = LOWER(:email)
            ORDER BY created_at DESC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute(['email' => $email]);
    $history = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(["history" => $history]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["error" => $e->getMessage()]);
}
exit;
