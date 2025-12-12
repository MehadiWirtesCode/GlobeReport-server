<?php
// CORS Header গুলো ঠিক আছে
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$allowedOrigins = ['http://localhost:3000'];
$origin = $_SERVER['HTTP_ORIGIN'] ?? '';
header("Access-Control-Allow-Origin: *");
if (in_array($origin, $allowedOrigins)) {
    header("Access-Control-Allow-Origin: $origin");
}

header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// === সংশোধিত রাউটিং লজিক ===
// SERVER_NAME এর পরে শুধুমাত্র পাথ অংশটুকু পার্স করা
$request = rtrim(parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH) ?: '/', '/');

// যদি সার্ভারটি index.php ফাইলটিকে অন্তর্ভুক্ত করে, তবে এটি /server/index.php হতে পারে।
// আমরা নিশ্চিত করতে চাই যে এটি রিকোয়েস্ট URI এর সাথে ম্যাচ করে।
if (strpos($request, '/index.php') !== false) {
    // index.php অংশটি বাদ দিন যদি এটি পাথে থাকে (এটি প্রায়শই বিল্ট-ইন সার্ভারে ঘটে)
    $request = str_replace('/index.php', '', $request);
}
// চূড়ান্তভাবে রিকোয়েস্ট URI কে স্ল্যাশ ছাড়া পরিষ্কার করুন
$request = rtrim($request, '/');


switch ($request) {
    case '':
    case '/':
        echo json_encode(["message" => "Hello from PHP server!"]);
        break;

    case '/api/signup':
        require __DIR__ . '/api/signup.php';
        break;

    case '/api/login':
        require __DIR__ . '/api/login.php';
        break;
    case '/api/posts':
        // posts.php এর জন্য
        require __DIR__ . '/api/posts.php';
        break;

    case '/api/getAllNews':
        // getAllNews.php এর জন্য
        require __DIR__ . '/api/getAllNews.php';
        break;

    default:
        http_response_code(404);
        echo json_encode(["message" => "404 Not Found", "request_uri" => $_SERVER['REQUEST_URI'] ?? 'N/A', "parsed_request" => $request]);
        break;
}
