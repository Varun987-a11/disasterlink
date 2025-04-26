<!--export_csv.php-->

<?php
$servername = "localhost";
$username = "root";
$password = "vKs$135#";
$dbname = "disasterlink_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$search = isset($_GET['search']) ? $_GET['search'] : '';
$status_filter = isset($_GET['status_filter']) ? $_GET['status_filter'] : '';

$sql = "SELECT id, name, location, issue_type, description, status, submitted_at 
        FROM reports 
        WHERE (name LIKE ? OR location LIKE ? OR issue_type LIKE ? OR description LIKE ?)";

if (!empty($status_filter)) {
    $sql .= " AND status = ?";
}

$sql .= " ORDER BY id ASC";

$searchTerm = "%$search%";
if (!empty($status_filter)) {
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $searchTerm, $searchTerm, $searchTerm, $searchTerm, $status_filter);
} else {
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $searchTerm, $searchTerm, $searchTerm, $searchTerm);
}

$stmt->execute();
$result = $stmt->get_result();

// Set headers for CSV
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=disaster_reports.csv');

// Open output stream
$output = fopen("php://output", "w");

// Output header row
fputcsv($output, ['ID', 'Name', 'Location', 'Issue Type', 'Description', 'Status', 'Submitted At']);

// Output data rows
while ($row = $result->fetch_assoc()) {
    fputcsv($output, $row);
}

fclose($output);
exit;
?>
