<?php
$path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

// If the request is for a real file, serve it directly
if ($path !== '/' && file_exists(__DIR__ . $path)) {
    return false;
}

require __DIR__ . '/index.php';
