<?php
// 1. Centralized Connection
// Adjust the path '../' if this file is in a subfolder like /api/
require_once 'includes/config.php'; 

// 2. Optimized Query (Fetching only what's needed for the markers)
$sql = "SELECT name, issue_type, latitude, longitude FROM reports WHERE latitude IS NOT NULL AND longitude IS NOT NULL";
$result = $conn->query($sql);

$reports = [];

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $reports[] = $row;
    }
}

// 3. Set JSON header and output
header('Content-Type: application/json');

// Using JSON_PRETTY_PRINT is helpful for debugging, but you can remove it for production
echo json_encode($reports);

// 4. Cleanup
$conn->close();
?>