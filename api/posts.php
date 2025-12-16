<?php


require_once __DIR__ . '/../config/db.php';
require __DIR__ . "/../vendor/autoload.php";


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["error" => "Invalid request"]);
    exit;
}

$title = $_POST['title'] ?? '';
$author = $_POST['author'] ?? '';
$category = $_POST['category'] ?? '';
$tags = $_POST['tags'] ?? '';
$content = $_POST['content'] ?? '';

$imageUrl = null;

// Handle Image Upload
if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {

    $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);


    $fileName = time() . "." . $extension;

    $targetDir = __DIR__ . "/../uploads/";
    $targetFile = $targetDir . $fileName;

    if (!move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
        echo json_encode(["error" => "Image upload failed"]);
        exit;
    }

    // Image URL for frontend access
    $imageUrl = "http://localhost:8000/uploads/" . $fileName;
}

// Insert into Supabase Postgres
$query = "INSERT INTO cms (title, author, category, tags, content, image)
          VALUES (:title, :author, :category, :tags, :content, :image)";

$stmt = $pdo->prepare($query);
$success = $stmt->execute([
    ':title' => $title,
    ':author' => $author,
    ':category' => $category,
    ':tags' => $tags,
    ':content' => $content,
    ':image' => $imageUrl
]);

if ($success) {
    echo json_encode(["message" => "Post created successfully"]);
} else {
    echo json_encode(["error" => "Database insert failed"]);
}
