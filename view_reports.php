<!--view_reports.php-->
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
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>DisasterLink | View Reports</title>

    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
        }
        .table-container {
            margin-top: 30px;
            overflow-x: auto;
        }
        .status-form {
            display: inline-block;
        }
        .message {
            width: 90%;
            margin: 10px auto;
            padding: 12px;
            border-radius: 5px;
            text-align: center;
            font-weight: bold;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .pending-row {
            background-color: #ffdddd !important;
        }
    </style>

    <script>
        window.onload = function() {
            setTimeout(function() {
                const messages = document.querySelectorAll('.message');
                messages.forEach(msg => msg.style.display = 'none');
            }, 4000);
        };
    </script>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">DisasterLink</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav ms-auto">
            <li class="nav-item"><a class="nav-link active" href="index.php">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="resources.php">Resources</a></li>
        <li class="nav-item"><a class="nav-link" href="submit_report.php">Submit Report</a></li>
        <li class="nav-item"><a class="nav-link" href="view_reports.php">View Reports</a></li>
        <li class="nav-item"><a class="nav-link" href="dashboard.php">Admin Dashboard</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- Alert messages -->
<div class="container mt-4">
    <?php
    if (isset($_SESSION['message'])) {
        echo "<div class='message success'>{$_SESSION['message']}</div>";
        unset($_SESSION['message']);
    }
    if (isset($_SESSION['error'])) {
        echo "<div class='message error'>{$_SESSION['error']}</div>";
        unset($_SESSION['error']);
    }
    ?>
</div>

<!-- Filter and Search -->
<div class="container mt-3">
    <h2 class="text-center">Submitted Reports</h2>
    <form method="GET" class="row g-2 justify-content-center mb-3" action="view_reports.php">
        <div class="col-md-4">
            <input type="text" name="search" class="form-control" placeholder="Search reports" value="<?= htmlspecialchars($search) ?>">
        </div>
        <div class="col-md-3">
            <select class="form-select" name="status_filter">
                <option value="">All Status</option>
                <option value="pending" <?= ($status_filter == 'pending') ? 'selected' : '' ?>>Pending</option>
                <option value="in progress" <?= ($status_filter == 'in progress') ? 'selected' : '' ?>>In Progress</option>
                <option value="resolved" <?= ($status_filter == 'resolved') ? 'selected' : '' ?>>Resolved</option>
            </select>
        </div>
        <div class="col-md-2">
            <input type="submit" class="btn btn-primary w-100" value="Search">
        </div>
    </form>

    <form method="GET" action="export_csv.php" class="text-center mb-3">
        <input type="hidden" name="search" value="<?= htmlspecialchars($search) ?>">
        <input type="hidden" name="status_filter" value="<?= htmlspecialchars($status_filter) ?>">
        <input type="submit" value="Download CSV" class="btn btn-success">
    </form>
</div>

<!-- Report Table -->
<div class="container table-container">
    <table class="table table-bordered table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Location</th>
                <th>Issue Type</th>
                <th>Description</th>
                <th>Status</th>
                <th>Time</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $status = strtolower(trim($row['status']));
                $rowClass = ($status === 'pending') ? 'pending-row' : '';

                echo "<tr class='{$rowClass}'>
                    <td>{$row['id']}</td>
                    <td>{$row['name']}</td>
                    <td>{$row['location']}</td>
                    <td>{$row['issue_type']}</td>
                    <td>{$row['description']}</td>
                    <td>
                        <form method='POST' action='update_status.php' class='status-form'>
                            <input type='hidden' name='report_id' value='{$row['id']}' />
                            <select name='status' class='form-select d-inline w-auto'>
                                <option value='pending' " . ($status == 'pending' ? 'selected' : '') . ">Pending</option>
                                <option value='in progress' " . ($status == 'in progress' ? 'selected' : '') . ">In Progress</option>
                                <option value='resolved' " . ($status == 'resolved' ? 'selected' : '') . ">Resolved</option>
                            </select>
                            <input type='submit' class='btn btn-sm btn-secondary' value='Change' />
                        </form>
                    </td>
                    <td>{$row['submitted_at']}</td>
                    <td>
                        <form action='delete_report.php' method='GET' onsubmit='return confirm(\"Are you sure you want to delete this report?\");'>
                            <input type='hidden' name='id' value='{$row['id']}'>
                            <input type='submit' value='Delete' class='btn btn-sm btn-danger'>
                        </form>
                    </td>
                </tr>";
            }
        } else {
            echo "<tr><td colspan='8' class='text-center'>No reports found.</td></tr>";
        }
        $conn->close();
        ?>
        </tbody>
    </table>
</div>

<!-- Footer -->
<footer class="bg-dark text-white text-center py-4 mt-5">
    <div class="container">
        <p class="mb-1">© 2025 DisasterLink. All rights reserved.</p>
        <p class="mb-1">Made by Varun, Varsha, Shlaghana & Sujan</p>
        <p class="mb-0">A J Institute of Engineering and Technology, Mangalore</p>
    </div>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

