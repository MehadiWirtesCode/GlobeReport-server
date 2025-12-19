<?php

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if (file_exists(__DIR__ . $uri) && !is_dir(__DIR__ . $uri)) {
    return false;
}

// ২. CORS
$origin = $_SERVER['HTTP_ORIGIN'] ?? '';
$allowedOrigins = ['http://localhost:3000'];

if (in_array($origin, $allowedOrigins)) {
    header("Access-Control-Allow-Origin: $origin");
} else {
    header("Access-Control-Allow-Origin: http://localhost:3000");
}

header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");


if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

header("Content-Type: application/json");


$request = $uri;
$request = str_replace('/server', '', $request);
$request = str_replace(['/index.php', '.php'], '', $request);
$request = rtrim($request, '/');

if (empty($request)) {
    $request = '/';
}

//
switch ($request) {
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
    case '/api/getSportsNews':
        require __DIR__ . '/api/getSportsNews.php';
        break;
    case '/api/getBusinessNews':
        require __DIR__ . '/api/getBusinessNews.php';
        break;
    case '/api/getLifestyleNews':
        require __DIR__ . '/api/getLifestyleNews.php';
        break;
    case '/api/users':
        require __DIR__ . '/api/users.php';
        break;
    case '/api/delete_user':
        require __DIR__ . '/api/delete_user.php';
        break;

    case '/api/subscription':
        require __DIR__ . '/api/subscription.php';
        break;
    case '/api/addToWatchLater':
        require __DIR__ . '/api/addToWatchLater.php';
        break;

      case '/api/getTotalWatchLaterItems':
        require __DIR__ . '/api/getTotalWatchLaterItems.php';
        break;

    case '/api/getUserWatchLater':
        require __DIR__ . '/api/getUserWatchLater.php';
        break;

     case '/api/removeFromWatchLater':
        require __DIR__ . '/api/removeFromWatchLater.php';
        break;

     case '/api/getSubscriptionHistory':
        require __DIR__ . '/api/getSubscriptionHistory.php';
        break;

     case '/api/getAllPosts':
        require __DIR__ . '/api/getAllPosts.php';
        break;

     case '/api/deletePost':
        require __DIR__ . '/api/deletePost.php';
        break;
    default:
        http_response_code(404);
        echo json_encode([
            "message" => "404 Not Found",
            "parsed_request" => $request
        ]);
        break;
}
