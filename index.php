<?php

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


$request = rtrim(parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH) ?: '/', '/');


if (strpos($request, '/index.php') !== false) {

    $request = str_replace('/index.php', '', $request);
}

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

        require __DIR__ . '/api/posts.php';
        break;

    case '/api/getAllNews':

        require __DIR__ . '/api/getAllNews.php';
        break;

    case '/api/getNationalNews':

        require __DIR__ . '/api/getNationalNews.php';
        break;
      case '/api/getInternationalNews':

        require __DIR__ . '/api/getInternationalNews.php';
        break;

    default:
        http_response_code(404);
        echo json_encode(["message" => "404 Not Found", "request_uri" => $_SERVER['REQUEST_URI'] ?? 'N/A', "parsed_request" => $request]);
        break;
}
