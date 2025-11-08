<?php
session_start();

// Include database configuration
require_once __DIR__ . '/config.php';

// Establish a secure connection
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check DB connection
if ($conn->connect_error) {
    die("Connection failed: " . htmlspecialchars($conn->connect_error));
}

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate input
    $report_id = isset($_POST['report_id']) ? (int) $_POST['report_id'] : 0;
    $status = trim($_POST['status'] ?? '');

    if ($report_id > 0 && !empty($status)) {
        // Use prepared statement
        $stmt = $conn->prepare("UPDATE reports SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $status, $report_id);

        if ($stmt->execute()) {
            $_SESSION['message'] = "Status updated successfully!";
        } else {
            $_SESSION['error'] = "Failed to update status. Please try again.";
        }

        $stmt->close();
    } else {
        $_SESSION['error'] = "Invalid input provided.";
    }

    // Redirect back to the view_reports page
    header("Location: view_reports.php");
    exit();
}

$conn->close();
?>

