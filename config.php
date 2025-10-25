<?php
// Load environment variables from .env file
if (file_exists(__DIR__ . '/.env')) {
    $lines = file(__DIR__ . '/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        // Skip commented lines
        if (str_starts_with(trim($line), '#')) continue;
        // Split KEY=VALUE
        [$key, $value] = explode('=', $line, 2);
        $_ENV[trim($key)] = trim($value);
    }
}

// Read database values from environment
$DB_HOST = $_ENV['DB_HOST'] ?? 'localhost';
$DB_NAME = $_ENV['DB_NAME'] ?? 'blogdb';
$DB_USER = $_ENV['DB_USER'] ?? 'root';
$DB_PASS = $_ENV['DB_PASS'] ?? '';

// Connect to the database using PDO
try {
    // Connecting to database
    $pdo = new PDO(
        "mysql:host=$DB_HOST;dbname=$DB_NAME;charset=utf8mb4",
        $DB_USER,
        $DB_PASS,
        [
            // Show clear error messages
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            // Fetch results as associative arrays
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );
} catch (Exception $e) {
    // Error handling
    die('Database connection error: ' . $e->getMessage());
}

// Start session
session_start();

// Helper functions
function isLoggedIn()
{
    return !empty($_SESSION['user']);
}

function currentUserId()
{
    return $_SESSION['user']['id'] ?? null;
}


