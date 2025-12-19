<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require_once __DIR__ . '/../config/db.php';

$email = isset($_GET['email']) ? trim($_GET['email']) : '';

if (empty($email)) {
    echo json_encode(["news" => []]);
    exit;
}

try {
    $sql = "SELECT c.id, c.title, c.image, c.category
            FROM cms c
            JOIN watchlater w ON c.id = w.\"newsid\"
            WHERE LOWER(w.email) = LOWER(:email)
            ORDER BY w.created_at DESC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([':email' => $email]);
    $news = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(["news" => $news]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["error" => $e->getMessage()]);
}
