<?php
// includes/create_admin.php
include 'config.php';

// Admin credentials
$username = "admin";
$email = "admin@mail";
$password = "123";  // Change this!

// Hash the password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Insert into DB
$stmt = $conn->prepare("INSERT INTO admins (username, email, password) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $username, $email, $hashed_password);

if ($stmt->execute()) {
    echo "✅ Admin user created successfully.";
} else {
    echo "❌ Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
