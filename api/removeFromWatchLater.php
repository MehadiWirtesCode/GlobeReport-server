<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

require_once __DIR__ . '/../config/db.php';

$input = json_decode(file_get_contents("php://input"), true);
$newsId = $input['id'] ?? '';
$email  = $input['userEmail'] ?? '';

try {
    $sql = "DELETE FROM watchlater WHERE email = :email AND \"newsid\" = :news_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['email' => $email, 'news_id' => $newsId]);

    echo json_encode(["status" => "success"]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["error" => $e->getMessage()]);
}
