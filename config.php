<?php
/**
 * DisasterLink - Secure Database Configuration
 * 
 * This file safely manages database credentials using environment variables.
 * It’s GitHub-safe — no passwords or secrets are hardcoded here.
 */

// If you’re using a local environment, you can create a `.env` file with values.
// Example `.env` content (not committed to GitHub):
// DB_HOST=localhost
// DB_USER=root
// DB_PASS=mysecretpassword
// DB_NAME=disasterlink_db

// Load environment variables if a .env file exists
if (file_exists(__DIR__ . '/.env')) {
    $lines = file(__DIR__ . '/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue; // skip comments
        list($name, $value) = array_map('trim', explode('=', $line, 2));
        $_ENV[$name] = $value;
    }
}

// Define constants safely with fallback defaults (for development only)
define('DB_HOST', $_ENV['DB_HOST'] ?? 'localhost');
define('DB_USER', $_ENV['DB_USER'] ?? 'root');
define('DB_PASS', $_ENV['DB_PASS'] ?? '');
define('DB_NAME', $_ENV['DB_NAME'] ?? 'disasterlink_db');

// Establish and test connection (optional; you can remove this check in production)
$conn = @new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) {
    die("Database connection failed. Please check your configuration.");
}
?>
