<?php
// Database config - EXACTLY as provided
$host = "localhost";
$user = "root";
$password = "vKs$135#";
$dbname = "disasterlink_db";

// Create connection
$conn = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = null;

// Handle form submission - EXACTLY as provided
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $location = trim($_POST['location']);
    $issue_type = trim($_POST['issue_type']);
    $description = trim($_POST['description']);
    $latitude = isset($_POST['latitude']) && $_POST['latitude'] !== '' ? floatval($_POST['latitude']) : null;
    $longitude = isset($_POST['longitude']) && $_POST['longitude'] !== '' ? floatval($_POST['longitude']) : null;

    $sql = "INSERT INTO reports (name, location, issue_type, description, latitude, longitude)
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssdd", $name, $location, $issue_type, $description, $latitude, $longitude);

    if ($stmt->execute()) {
        $message = "Thank you! Your report has been submitted.";
    } else {
        $message = "Error: " . $stmt->error;
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
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />

    <style>
        :root {
            --dl-primary: #00bcd4;
            --dl-primary-dark: #0097a7;
            --dl-bg: #f8fafc;
            --dl-text-dark: #1e293b;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--dl-bg);
            color: var(--dl-text-dark);
            padding-top: 100px; /* Space for fixed navbar */
        }

        h2, h5, .navbar-brand {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 700;
        }

        /* Navbar Style from Index */
        .navbar {
            background-color: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(12px);
            box-shadow: 0 2px 15px rgba(0,0,0,0.04);
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }

        .navbar-brand {
            color: var(--dl-text-dark) !important;
        }

        /* Refined Form Container */
        .form-container {
            background-color: #fff;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            border: 1px solid rgba(0, 0, 0, 0.02);
            max-width: 800px;
            margin: 0 auto 50px;
        }

        .form-label {
            font-weight: 600;
            font-size: 0.9rem;
            color: #475569;
        }

        .form-control, .form-select {
            border-radius: 12px;
            padding: 12px;
            border: 1px solid #e2e8f0;
            background-color: #fdfdfd;
        }

        .form-control:focus {
            box-shadow: 0 0 0 4px rgba(0, 188, 212, 0.1);
            border-color: var(--dl-primary);
        }

        /* Success Message Styling */
        .message {
            text-align: center;
            padding: 15px;
            border-radius: 12px;
            margin-bottom: 25px;
            background-color: #ecfdf5;
            color: #059669;
            border: 1px solid #10b981;
        }

        /* Map Styling */
        #map {
            height: 350px;
            margin: 15px 0 25px;
            border: none;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            z-index: 1; /* Ensure dropdowns don't hide under map */
        }

        .btn-primary {
            background-color: var(--dl-primary);
            border: none;
            border-radius: 12px;
            padding: 14px;
            font-weight: 700;
            width: 100%;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: var(--dl-primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 188, 212, 0.2);
        }

        footer {
            background-color: #0f172a;
            color: #f1f5f9;
            padding: 40px 0;
            margin-top: auto;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg fixed-top">
    <div class="container">
        <a class="navbar-brand" href="../index.php">
            <i class="bi bi-broadcast text-info me-2"></i>DisasterLink
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="../index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="resources.php">Resources</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container">
    <div class="form-container">
        <h2 class="text-center mb-2">Submit a Disaster Report</h2>
        <p class="text-center text-muted mb-4">Provide details to help emergency teams respond faster.</p>

        <?php if ($message): ?>
            <div class="message">
                <i class="bi bi-check-circle-fill me-2"></i><?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="submit_report.php">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="name" class="form-label">Your Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Full name" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="location" class="form-label">Location (Area Name)</label>
                    <input type="text" class="form-control" id="location" name="location" placeholder="e.g. Kottara Chowki" required>
                </div>
            </div>

            <div class="mb-3">
                <label for="issue_type" class="form-label">Issue Type</label>
                <select class="form-select" id="issue_type" name="issue_type" required>
                    <option value="">Select the type of emergency</option>
                    <option value="blocked road">Blocked Road</option>
                    <option value="stranded people">Stranded People</option>
                    <option value="damaged property">Damaged Property</option>
                    <option value="flooding">Flooding</option>
                    <option value="food">Food/Water Shortage</option>
                    <option value="other">Other</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="description" class="form-label">Detailed Description</label>
                <textarea class="form-control" id="description" name="description" rows="4" placeholder="Describe the situation..." required></textarea>
            </div>

            <input type="hidden" id="latitude" name="latitude">
            <input type="hidden" id="longitude" name="longitude">

            <div class="mb-2">
                <h5 class="mb-1">Select Location on Map</h5>
                <p class="small text-muted mb-3">Click on the map to pin the exact emergency location.</p>
                <div id="map"></div>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="bi bi-send-fill me-2"></i>Submit Urgent Report
            </button>
        </form>
    </div>
</div>

<footer>
    <div class="container text-center">
        <p class="mb-1">© 2025 **DisasterLink**. All rights reserved.</p>
        <p class="mb-1">Made by **Varun, Varsha, Shlaghana & Sujan**</p>
        <p class="small text-white-50">A J Institute of Engineering and Technology, Mangalore</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
<script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>

<script>
// Initialize Leaflet Map - PRESERVED LOGIC
var map = L.map('map').setView([12.87, 74.88], 10);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
}).addTo(map);

var marker;

map.on('click', function (e) {
    var lat = e.latlng.lat.toFixed(6);
    var lng = e.latlng.lng.toFixed(6);

    document.getElementById('latitude').value = lat;
    document.getElementById('longitude').value = lng;

    if (marker) {
        marker.setLatLng(e.latlng);
    } else {
        marker = L.marker(e.latlng).addTo(map);
    }

    marker.bindPopup("Pinned Location:<br>" + lat + ", " + lng).openPopup();
});
</script>

</body>
</html>