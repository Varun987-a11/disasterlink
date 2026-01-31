<?php
$host = 'localhost';
$db = 'disasterlink_db';
$user = 'root';
$pass = 'vKs$135#'; // use your password if set

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
