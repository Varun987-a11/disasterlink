<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head><title>Admin Home</title></head>
<body>
<h2>Welcome Admin, <?php echo $_SESSION['admin_username']; ?>!</h2>
<p><a href="view_reports.php">View Reports</a></p>
<p><a href="dashboard.php">Dashboard</a></p>
<p><a href="logout.php">Logout</a></p>
</body>
</html>
