<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

require_once __DIR__ . '/../config/db.php';

$input = json_decode(file_get_contents("php://input"), true);
$id = $input['id'] ?? '';

if (!$id) {
    echo json_encode(["status" => "error", "message" => "ID missing"]);
    exit;
}

try {
    $sql = "DELETE FROM cms WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);

    echo json_encode(["status" => "success", "message" => "Post deleted successfully"]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["error" => $e->getMessage()]);
}
