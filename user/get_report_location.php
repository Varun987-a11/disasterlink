<?php
$servername = "localhost";
$username = "root";
$password = "vKs$135#";
$dbname = "disasterlink_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT name, issue_type, latitude, longitude FROM reports WHERE latitude IS NOT NULL AND longitude IS NOT NULL";
$result = $conn->query($sql);

$reports = [];

while ($row = $result->fetch_assoc()) {
    $reports[] = $row;
}

header('Content-Type: application/json');
echo json_encode($reports);

$conn->close();
?>
