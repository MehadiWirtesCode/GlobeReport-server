<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
require_once __DIR__ . '/../config/db.php';

try {
    $stmt = $pdo->query("SELECT id, author, category, tags, content, image, created_at FROM cms WHERE category = 'sports' ORDER BY id DESC");
    $news = $stmt->fetchAll();

    // Format each news item for frontend
    $newsData = array_map(function($row){
        return [
            "id" => $row["id"],
            "title" => $row["tags"],
            "category" => $row["category"],
            "author" => $row["author"],
            "image" => $row["image"],
            "excerpt" => substr($row["content"], 0, 120),
            "date" => $row["created_at"] ?? date("Y-m-d")
        ];
    }, $news);

    echo json_encode([
        "message" => "News loaded successfully",
        "news" => $newsData
    ]);
    http_response_code(200);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        "message" => "Failed to fetch news",
        "error" => $e->getMessage()
    ]);
}