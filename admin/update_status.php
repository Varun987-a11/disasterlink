<?php
session_start();

// 1. Check if admin is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../includes/admin_login.php");
    exit();
}

// 2. Centralized Connection (Hides credentials from Git)
require_once '../includes/config.php'; 

// 3. Handle the status update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $report_id = $_POST['report_id'];
    $status = $_POST['status'];

    // Update the status of the report using prepared statements
    $sql = "UPDATE reports SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $status, $report_id);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Status updated successfully!";
    } else {
        $_SESSION['error'] = "Failed to update status: " . $conn->error;
    }

    $stmt->close();

    // Redirect back to the reports view
    header("Location: view_reports.php");
    exit();
}

// 4. Close connection if reached via direct GET access
$conn->close();
header("Location: view_reports.php");
exit();
?>