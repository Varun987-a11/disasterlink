<!--delete_report.php-->
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

// Check if ID is passed
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "DELETE FROM reports WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        header("Location: view_reports.php"); // redirect back
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
} else {
    echo "No ID specified for deletion.";
}

$conn->close();
?>
