<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$allowedOrigins = ['http://localhost:3000'];
$origin = $_SERVER['HTTP_ORIGIN'] ?? '';

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

// FIXED ROUTE PARSING
$request = rtrim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

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

    default:
        http_response_code(404);
        echo json_encode(["message" => "404 Not Found"]);
        break;
}
