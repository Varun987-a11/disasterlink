<?php
session_start();

// 1. Security Check: Only allow logged-in admins to export data
if (!isset($_SESSION['admin_logged_in'])) {
    die("Unauthorized access.");
}

// 2. Centralized Connection (Hides credentials from Git)
require_once '../includes/config.php'; 

$search = isset($_GET['search']) ? $_GET['search'] : '';
$status_filter = isset($_GET['status_filter']) ? $_GET['status_filter'] : '';

// 3. Query Logic - PRESERVED EXACTLY
$sql = "SELECT id, name, location, issue_type, description, status, submitted_at 
        FROM reports 
        WHERE (name LIKE ? OR location LIKE ? OR issue_type LIKE ? OR description LIKE ?)";

if (!empty($status_filter)) {
    $sql .= " AND status = ?";
}
$sql .= " ORDER BY id ASC";

$searchTerm = "%$search%";
$stmt = $conn->prepare($sql);

if (!empty($status_filter)) {
    $stmt->bind_param("sssss", $searchTerm, $searchTerm, $searchTerm, $searchTerm, $status_filter);
} else {
    $stmt->bind_param("ssss", $searchTerm, $searchTerm, $searchTerm, $searchTerm);
}

$stmt->execute();
$result = $stmt->get_result();

// 4. Set headers for CSV download
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=disaster_reports_' . date('Y-m-d') . '.csv');

// 5. Open output stream
$output = fopen("php://output", "w");

// Output header row
fputcsv($output, ['ID', 'Name', 'Location', 'Issue Type', 'Description', 'Status', 'Submitted At']);

// Output data rows
while ($row = $result->fetch_assoc()) {
    fputcsv($output, $row);
}

// 6. Cleanup
fclose($output);
$stmt->close();
$conn->close();
exit;
?>