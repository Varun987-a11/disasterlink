<?php
// Load environment variables from a separate config file
// (Never commit .env to GitHub!)
require_once __DIR__ . '/config.php';

// Create connection
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . htmlspecialchars($conn->connect_error));
}

// Get form data if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $location = trim($_POST['location']);
    $issue_type = trim($_POST['issue_type']);
    $description = trim($_POST['description']);

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare(
        "INSERT INTO reports (name, location, issue_type, description)
         VALUES (?, ?, ?, ?)"
    );

    $stmt->bind_param("ssss", $name, $location, $issue_type, $description);

    if ($stmt->execute()) {
        $message = "Thank you! Your report has been submitted.";
    } else {
        $message = "Error submitting report. Please try again later.";
    }

    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>DisasterLink | Submit Report</title>

    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }
        .form-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            margin-top: 30px;
        }
        .message {
            text-align: center;
            margin-top: 50px;
        }
    </style>
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

<!-- Report Form -->
<div class="container form-container">
    <h2 class="text-center mb-4">Submit a Disaster Report</h2>
    <?php if (isset($message)): ?>
        <div class="alert alert-info text-center"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>
    <form method="POST" action="">
        <div class="mb-3">
            <label for="name" class="form-label">Your Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="mb-3">
            <label for="location" class="form-label">Location</label>
            <input type="text" class="form-control" id="location" name="location" required>
        </div>
        <div class="mb-3">
            <label for="issue_type" class="form-label">Issue Type</label>
            <select class="form-select" id="issue_type" name="issue_type" required>
                <option value="blocked road">Blocked Road</option>
                <option value="stranded people">Stranded People</option>
                <option value="damaged property">Damaged Property</option>
                <option value="flooding">Flooding</option>
                <option value="other">Other</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit Report</button>
    </form>
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
