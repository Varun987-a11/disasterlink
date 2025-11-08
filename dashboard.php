<?php
require_once __DIR__ . '/config.php';

// Establish secure database connection
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if ($conn->connect_error) {
    die("Database connection failed: " . htmlspecialchars($conn->connect_error));
}

// Initialize counters
$total = $pending = $in_progress = $resolved = 0;

// Use prepared statement for security and reliability
$sql = "SELECT status, COUNT(*) AS count FROM reports GROUP BY status";
$result = $conn->query($sql);

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $status = strtolower(trim($row['status']));
        switch ($status) {
            case 'pending':
                $pending = $row['count'];
                break;
            case 'in progress':
                $in_progress = $row['count'];
                break;
            case 'resolved':
                $resolved = $row['count'];
                break;
        }
        $total += $row['count'];
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>DisasterLink | Dashboard</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">

  <style>
    body {
      font-family: 'Roboto', sans-serif;
      background-color: #f8f9fa;
    }
    .card h5 {
      font-weight: bold;
    }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">DisasterLink</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
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

<!-- Dashboard Content -->
<div class="container my-5">
  <h1 class="text-center mb-4">Admin Dashboard</h1>

  <div class="row g-4 justify-content-center">
    <div class="col-sm-6 col-md-3">
      <div class="card text-center shadow-sm">
        <div class="card-body">
          <h5>Total Reports</h5>
          <p class="fs-4 text-primary"><?= htmlspecialchars($total) ?></p>
        </div>
      </div>
    </div>

    <div class="col-sm-6 col-md-3">
      <div class="card text-center shadow-sm">
        <div class="card-body">
          <h5>Pending</h5>
          <p class="fs-4 text-warning"><?= htmlspecialchars($pending) ?></p>
        </div>
      </div>
    </div>

    <div class="col-sm-6 col-md-3">
      <div class="card text-center shadow-sm">
        <div class="card-body">
          <h5>In Progress</h5>
          <p class="fs-4 text-info"><?= htmlspecialchars($in_progress) ?></p>
        </div>
      </div>
    </div>

    <div class="col-sm-6 col-md-3">
      <div class="card text-center shadow-sm">
        <div class="card-body">
          <h5>Resolved</h5>
          <p class="fs-4 text-success"><?= htmlspecialchars($resolved) ?></p>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Footer -->
<footer class="bg-dark text-white text-center py-4">
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
