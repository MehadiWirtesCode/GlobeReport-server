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

    $checkSql = "SELECT created_at FROM subscription WHERE email = :email AND level = :level ORDER BY created_at DESC LIMIT 1";
    $checkStmt = $pdo->prepare($checkSql);
    $checkStmt->execute(['email' => $email, 'level' => $level]);
    $lastSubscription = $checkStmt->fetch(PDO::FETCH_ASSOC);

    if ($lastSubscription) {
        $lastDate = new DateTime($lastSubscription['created_at']);
        $currentDate = new DateTime();
        $interval = $lastDate->diff($currentDate);


        if ($level === 'basic' || $level === 'premium') {

            if ($interval->m < 1 && $interval->y == 0) {
                http_response_code(409);
                echo json_encode(["message" => "You can buy this subscription again after 1 month."]);
                exit;
            }
        } elseif ($level === 'gold') {

            if ($interval->y < 3) {
                http_response_code(409);
                echo json_encode(["message" => "You can buy Gold subscription again after 3 years."]);
                exit;
            }
        }
    }

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
    echo json_encode(["message" => "Database Error: " . $e->getMessage()]);
}
exit;
