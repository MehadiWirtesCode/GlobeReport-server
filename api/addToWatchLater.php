<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

require_once __DIR__ . '/../config/db.php';

$input = json_decode(file_get_contents("php://input"), true);

$newsId = $input['id'] ?? '';
$email  = $input['userEmail'] ?? '';

if (!$newsId || !$email) {
    http_response_code(400);
    echo json_encode(["message" => "News ID and Email are required"]);
    exit;
}

try {
    $checkSql = "SELECT id FROM watchlater WHERE email = :email AND \"newsid\" = :news_id";
    $checkStmt = $pdo->prepare($checkSql);
    $checkStmt->execute([
        'email'   => $email,
        'news_id' => $newsId
    ]);

    if ($checkStmt->fetch()) {
        http_response_code(400);
        echo json_encode(["message" => "Already saved to Watch Later"]);
        exit;
    }

    $sql = "INSERT INTO watchlater (email, \"newsid\") VALUES (:email, :news_id)";
    $stmt = $pdo->prepare($sql);

    $result = $stmt->execute([
        'email'   => $email,
        'news_id' => $newsId
    ]);

    if ($result) {
        http_response_code(201);
        echo json_encode(["message" => "Saved successfully!"]);
    }

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        "message" => "Database Error",
        "error" => $e->getMessage()
    ]);
}
exit;
