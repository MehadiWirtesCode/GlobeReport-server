<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require_once __DIR__ . '/../config/db.php';

try {
    $email = isset($_GET['email']) ? trim($_GET['email']) : '';

    if (empty($email)) {
        http_response_code(200);
        echo json_encode(["totalWatchLaterItems" => 0]);
        exit;
    }

    $query = "SELECT COUNT(*) AS total FROM watchlater WHERE LOWER(email) = LOWER(:email)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([':email' => $email]);

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $count = $result ? (int)$result['total'] : 0;

    http_response_code(200);
    echo json_encode([
        "totalWatchLaterItems" => $count
    ]);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        "totalWatchLaterItems" => 0,
        "error" => "Database Error"
    ]);
}
exit;
