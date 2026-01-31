<!--update_status.php-->
session_start();

<?php
// DB connection
$servername = "localhost";
$username = "root";
$password = "vKs$135#";
$dbname = "disasterlink_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check DB connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the report ID and new status from the form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $report_id = $_POST['report_id'];
    $status = $_POST['status'];

    // Update the status of the report
    $sql = "UPDATE reports SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $status, $report_id);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Status updated successfully!";
    } else {
        $_SESSION['error'] = "Failed to update status.";
    }
    if ($stmt->execute()) {
        $_SESSION['message'] = "Status updated successfully!";
    } else {
        $_SESSION['error'] = "Failed to update status.";
    }

    $stmt->close();

    // Redirect back to the view_reports page after successful update
    header("Location: view_reports.php");
    exit();
}

$conn->close();
?>
