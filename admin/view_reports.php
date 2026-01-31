<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../includes/admin_login.php");
    exit();
}

// DB connection - PRESERVED EXACTLY
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

// Query Logic - PRESERVED EXACTLY
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>DisasterLink | View Reports</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

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

        .report-card {
            background: white;
            border-radius: 24px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.03);
            border: 1px solid #e2e8f0;
        }

        .table thead th {
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
            color: #64748b;
            padding: 1.2rem;
            border-bottom: 2px solid #f1f5f9;
        }

        .table tbody td {
            padding: 1.2rem;
            vertical-align: middle;
            color: #1e293b;
            border-bottom: 1px solid #f1f5f9;
        }

        .pending-row { background-color: #fff1f2 !important; }

        h1, .brand-name {
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

        .message {
            border-radius: 12px;
            padding: 1rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <div class="brand-name fs-4 mb-5 text-info">
            <i class="bi bi-shield-check"></i> DisasterLink
        </div>
        
        <nav class="flex-grow-1">
            <a href="dashboard.php" class="nav-link-custom">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            <a href="view_reports.php" class="nav-link-custom active">
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
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <div>
                <h1>Emergency Reports</h1>
                <p class="text-secondary">Manage and update active disaster submissions.</p>
            </div>
            <a href="export_csv.php?search=<?= urlencode($search) ?>&status_filter=<?= urlencode($status_filter) ?>" class="btn btn-outline-success rounded-pill px-4">
                <i class="bi bi-file-earmark-spreadsheet me-2"></i>Export CSV
            </a>
        </div>

        <?php
        if (isset($_SESSION['message'])) {
            echo "<div class='message alert-success bg-success-subtle text-success'><i class='bi bi-check-circle me-2'></i><strong>{$_SESSION['message']}</strong></div>";
            unset($_SESSION['message']);
        }
        if (isset($_SESSION['error'])) {
            echo "<div class='message alert-danger bg-danger-subtle text-danger'><i class='bi bi-exclamation-triangle me-2'></i><strong>{$_SESSION['error']}</strong></div>";
            unset($_SESSION['error']);
        }
        ?>

        <div class="report-card mb-4 p-3">
            <form method="GET" class="row g-2" action="view_reports.php">
                <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-end-0 text-muted"><i class="bi bi-search"></i></span>
                        <input type="text" name="search" class="form-control border-start-0 ps-0" placeholder="Search reports..." value="<?= htmlspecialchars($search) ?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <select class="form-select" name="status_filter">
                        <option value="">All Statuses</option>
                        <option value="pending" <?= ($status_filter == 'pending') ? 'selected' : '' ?>>Pending</option>
                        <option value="in progress" <?= ($status_filter == 'in progress') ? 'selected' : '' ?>>In Progress</option>
                        <option value="resolved" <?= ($status_filter == 'resolved') ? 'selected' : '' ?>>Resolved</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-info w-100 fw-bold">Apply Filters</button>
                </div>
            </form>
        </div>

        <div class="report-card p-0 overflow-hidden">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Reporter</th>
                            <th>Location</th>
                            <th>Issue</th>
                            <th>Status Control</th>
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
                                <td><strong>#{$row['id']}</strong></td>
                                <td>" . htmlspecialchars($row['name']) . "</td>
                                <td>" . htmlspecialchars($row['location']) . "</td>
                                <td><span class='badge bg-dark-subtle text-dark border'>" . htmlspecialchars($row['issue_type']) . "</span></td>
                                <td>
                                    <form method='POST' action='update_status.php' class='d-flex gap-1'>
                                        <input type='hidden' name='report_id' value='{$row['id']}' />
                                        <select name='status' class='form-select form-select-sm w-auto shadow-sm'>
                                            <option value='pending' " . ($status == 'pending' ? 'selected' : '') . ">Pending</option>
                                            <option value='in progress' " . ($status == 'in progress' ? 'selected' : '') . ">In Progress</option>
                                            <option value='resolved' " . ($status == 'resolved' ? 'selected' : '') . ">Resolved</option>
                                        </select>
                                        <button type='submit' class='btn btn-sm btn-dark'><i class='bi bi-arrow-repeat'></i></button>
                                    </form>
                                </td>
                                <td class='small'>" . date("M d, H:i", strtotime($row['submitted_at'])) . "</td>
                                <td>
                                    <a href='delete_report.php?id={$row['id']}' class='btn btn-sm btn-outline-danger border-0' onclick='return confirm(\"Are you sure?\");'>
                                        <i class='bi bi-trash3'></i>
                                    </a>
                                </td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7' class='text-center py-5 text-muted'>No reports found.</td></tr>";
                    }
                    $conn->close();
                    ?>
                    </tbody>
                </table>
            </div>
        </div>

        <footer>
            <div class="d-flex justify-content-between">
                <p>&copy; 2025 <strong>DisasterLink</strong>. All rights reserved.</p>
                <p>Developed by <strong>Varun</strong>, AJIET Mangalore.</p>
            </div>
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>