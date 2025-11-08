<?php
session_start();
require_once __DIR__ . '/config.php';

// Establish DB connection
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if ($conn->connect_error) {
    die("Database connection failed: " . htmlspecialchars($conn->connect_error));
}

// Validate and sanitize ID
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int) $_GET['id'];

    // Prepare statement to avoid SQL injection
    $stmt = $conn->prepare("DELETE FROM reports WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Report deleted successfully!";
    } else {
        $_SESSION['error'] = "Failed to delete the report. Please try again.";
    }

    $stmt->close();
    $conn->close();

    // Redirect back to view_reports page
    header("Location: view_reports.php");
    exit();
} else {
    $_SESSION['error'] = "Invalid or missing report ID.";
    header("Location: view_reports.php");
    exit();
}
?>
