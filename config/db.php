<?php
require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Build DSN string
$dsn = sprintf(
    "pgsql:host=%s;port=%s;dbname=%s",
    $_ENV['SUPA_HOST'],
    $_ENV['SUPA_PORT'],
    $_ENV['SUPA_DB']
);

try {
    $pdo = new PDO($dsn, $_ENV['SUPA_USER'], $_ENV['SUPA_PASS'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false
    ]);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        "message" => "Database connection failed"
    ]);
    exit;
}
