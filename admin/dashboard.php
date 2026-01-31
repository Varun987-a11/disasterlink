<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../includes/admin_login.php");
    exit();
}

// 1. Centralized Connection (Now hides your password from Git)
require_once '../includes/config.php'; 

// Initialize counters - PRESERVED LOGIC
$total = $pending = $in_progress = $resolved = 0;

$sql = "SELECT status, COUNT(*) as count FROM reports GROUP BY status";
$result = $conn->query($sql);

if ($result) {
    while($row = $result->fetch_assoc()) {
        $status = strtolower($row['status']);
        if ($status == "pending") $pending = $row['count'];
        else if ($status == "in progress") $in_progress = $row['count'];
        else if ($status == "resolved") $resolved = $row['count'];
        $total += $row['count'];
    }
}

// Fetch markers for the map - PRESERVED LOGIC
$markers = [];
$sql = "SELECT name, location, issue_type, latitude, longitude FROM reports WHERE latitude IS NOT NULL AND longitude IS NOT NULL";
$result = $conn->query($sql);

if ($result) {
    while($row = $result->fetch_assoc()) {
        $markers[] = [
            'name' => $row['name'],
            'location' => $row['location'],
            'issue_type' => $row['issue_type'],
            'latitude' => $row['latitude'],
            'longitude' => $row['longitude']
        ];
    }
}
// Note: $conn->close() removed from top to ensure stability, 
// usually closed at the very bottom or left to PHP's garbage collection.
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DisasterLink | Admin Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"/>

    <style>
        :root {
            --dl-admin-dark: #0f172a;
            --dl-primary: #00bcd4;
            --dl-sidebar-width: 260px;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
            display: flex;
            margin: 0;
        }

        .sidebar {
            width: var(--dl-sidebar-width);
            background-color: var(--dl-admin-dark);
            height: 100vh;
            position: fixed;
            color: white;
            padding: 2rem 1.5rem;
            display: flex;
            flex-direction: column;
            z-index: 1000;
        }

        .main-content {
            margin-left: var(--dl-sidebar-width);
            width: calc(100% - var(--dl-sidebar-width));
            padding: 2rem 3rem;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .nav-link-custom {
            color: #94a3b8;
            text-decoration: none;
            display: flex;
            align-items: center;
            padding: 0.8rem 1rem;
            border-radius: 12px;
            margin-bottom: 0.5rem;
            transition: all 0.2s;
        }

        .nav-link-custom:hover, .nav-link-custom.active {
            background: rgba(0, 188, 212, 0.1);
            color: var(--dl-primary);
        }

        .nav-link-custom i { margin-right: 12px; font-size: 1.2rem; }

        .stat-card {
            background: white;
            border-radius: 20px;
            padding: 1.5rem;
            border: 1px solid rgba(0,0,0,0.05);
            box-shadow: 0 4px 15px rgba(0,0,0,0.02);
            text-align: center;
        }

        #map {
            height: 500px;
            width: 100%;
            border-radius: 24px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            border: 1px solid #e2e8f0;
            z-index: 1;
        }

        h1, h2, h4, .brand-name {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 700;
        }

        .logout-btn {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
            border: none;
            padding: 0.8rem;
            border-radius: 12px;
            width: 100%;
            font-weight: 600;
            transition: 0.3s;
        }

        .logout-btn:hover { background: #ef4444; color: white; }

        footer {
            margin-top: auto;
            padding-top: 2rem;
            border-top: 1px solid #e2e8f0;
            color: #64748b;
            font-size: 0.85rem;
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <div class="brand-name fs-4 mb-5 text-info">
            <i class="bi bi-shield-check"></i> DisasterLink
        </div>
        
        <nav class="flex-grow-1">
            <a href="dashboard.php" class="nav-link-custom active">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            <a href="view_reports.php" class="nav-link-custom">
                <i class="bi bi-file-earmark-text"></i> View Reports
            </a>
            <a href="../index.php" class="nav-link-custom">
                <i class="bi bi-globe"></i> Public Site
            </a>
        </nav>

        <div class="mt-auto">
            <div class="small text-secondary mb-3">Admin: <strong><?php echo htmlspecialchars($_SESSION['admin_username']); ?></strong></div>
            <a href="../includes/logout.php" class="text-decoration-none">
                <button class="logout-btn"><i class="bi bi-box-arrow-left me-2"></i>Logout</button>
            </a>
        </div>
    </div>

    <div class="main-content">
        <div class="mb-5">
            <h1>Admin Dashboard</h1>
            <p class="text-secondary">Real-time oversight of reported disaster incidents.</p>
        </div>

        <div class="row g-4 mb-5">
            <div class="col-md-3">
                <div class="stat-card">
                    <h6 class="text-uppercase text-secondary small fw-bold">Total</h6>
                    <div class="fs-2 fw-bold text-dark"><?= $total ?></div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <h6 class="text-uppercase text-warning small fw-bold">Pending</h6>
                    <div class="fs-2 fw-bold"><?= $pending ?></div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <h6 class="text-uppercase text-info small fw-bold">In Progress</h6>
                    <div class="fs-2 fw-bold"><?= $in_progress ?></div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <h6 class="text-uppercase text-success small fw-bold">Resolved</h6>
                    <div class="fs-2 fw-bold"><?= $resolved ?></div>
                </div>
            </div>
        </div>

        <div class="mb-5">
            <h2 class="mb-4">Incident Map</h2>
            <div id="map"></div>
        </div>

        <footer>
            <div class="d-flex justify-content-between">
                <p>&copy; 2025 <strong>DisasterLink</strong>. All rights reserved.</p>
                <p>Developed by <strong>Varun</strong>, AJIET Mangalore.</p>
            </div>
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
    <script>
        var map = L.map('map').setView([12.87, 74.88], 11);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
        }).addTo(map);

        <?php foreach ($markers as $marker): ?>
            L.marker([<?= $marker['latitude'] ?>, <?= $marker['longitude'] ?>])
                .addTo(map)
                .bindPopup(
                    `<strong><?= addslashes($marker['issue_type']) ?></strong><br>` +
                    `Reported by: <strong><?= addslashes($marker['name']) ?></strong><br>` +
                    `Location: <?= addslashes($marker['location']) ?>`
                );
        <?php endforeach; ?>
    </script>
</body>
</html>
<?php $conn->close(); ?>