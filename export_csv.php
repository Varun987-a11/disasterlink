<?php
require_once __DIR__ . '/config.php';

// Connect to database
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) {
    die("Connection failed: " . htmlspecialchars($conn->connect_error));
}

// Retrieve filters safely
$search = trim($_GET['search'] ?? '');
$status_filter = trim($_GET['status_filter'] ?? '');

// Build SQL query
$sql = "SELECT id, name, location, issue_type, description, status, submitted_at 
        FROM reports 
        WHERE (name LIKE ? OR location LIKE ? OR issue_type LIKE ? OR description LIKE ?)";

if (!empty($status_filter)) {
    $sql .= " AND status = ?";
}
$sql .= " ORDER BY id ASC";

$searchTerm = "%$search%";

// Prepare statement
if (!empty($status_filter)) {
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $searchTerm, $searchTerm, $searchTerm, $searchTerm, $status_filter);
} else {
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $searchTerm, $searchTerm, $searchTerm, $searchTerm);
}

$stmt->execute();
$result = $stmt->get_result();

// Check if any data exists
if ($result->num_rows === 0) {
    header('Content-Type: text/plain; charset=utf-8');
    echo "No records found for export.";
    exit;
}

// Send headers for CSV file download
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="disaster_reports.csv"');

// Open output stream
$output = fopen('php://output', 'w');

// CSV header row
fputcsv($output, ['ID', 'Name', 'Location', 'Issue Type', 'Description', 'Status', 'Submitted At']);

// Output rows
while ($row = $result->fetch_assoc()) {
    // Sanitize text fields to avoid CSV injection or formatting issues
    foreach ($row as &$value) {
        $value = preg_replace('/^([=+\-@])/i', "'$1", $value);
    }
    fputcsv($output, $row);
}

// Close resources
fclose($output);
$stmt->close();
$conn->close();
exit;
?>


