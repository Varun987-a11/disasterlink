<?php
session_start();
if (!isset($_SESSION['user_logged_in'])) {
    header("Location: user_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head><title>User Home</title></head>
<body>
<h2>Welcome, <?php echo $_SESSION['username']; ?>!</h2>
<p><a href="resources.php">View Resources</a></p>
<p><a href="submit_report.php">Submit Report</a></p>
<p><a href="logout.php">Logout</a></p>
</body>
</html>
